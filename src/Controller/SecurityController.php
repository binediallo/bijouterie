<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription",name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, PromoRepository $promoRepository)
    {
        //userPasswordUncoderInterface pour pouvoir fonctionner attend de l'objet User, que celui ci, hérite de la class UserInterface, cette dernière class attend des méthodes bien précises afin de s'assurer du bon fonctionnement de l'authentification (cf User Entitiy)
        $user= new User();

        $form=$this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ):

            $hash=$encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $user->setPromo(0);
            $user->setDateInscription(new \DateTime());


            $nom=$request->request->get('registration')['nom'];
            $prenom=$request->request->get('registration')['prenom'];
            $to=$request->request->get('registration')['email'];
            $date = strtotime("now +10 day");
            $datef = date('d-m-Y', $date);
            $promo=$promoRepository->findByRegistrationName('BIENVENUE');
            $promotion=$promo->getNom();
            $remise=$promo->getRemise();
            $montant=$promo->getMontantmin();


            $transporter = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('dorancocovid2021@gmail.com')
                ->setPassword('Dorancosalle06');



            $mailer = new \Swift_Mailer($transporter);

            $mess = "Bienvenue $prenom $nom, pour vous remecier de votre inscription, bénéficiez dès à présent et jusqu'au $datef, d'une remise de bienvenue de $remise € pour tout achat d'un montant minimul de $montant € avec le code promotionnel : $promotion (à entrer au moment de votre commande";

            $motif = "Cadeau de bienvenue";
            $from = 'dorancocovid2021@gmail.com';
            $message = (new \Swift_Message("$motif"))
                ->setFrom($from)
                ->setTo([$to]);

            $cid = $message->embed(\Swift_Image::fromPath('photos/20210616134911-60ca0157814e7-boucle3.jpg'));
            $message->setBody(
                $this->renderView('front/mail_template.html.twig', [
                    'message' => $mess,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'motif' => $motif,
                    'email' => $from,
                    'cid' => $cid
                ]),
                'text/html'
            );
            $mailer->send($message);

            $manager->persist($user);
            $manager->flush();

            $this ->addFlash('success', "Félicitation, votre compte a bien été crée. Vous pouvez à présent vous connecter !");

            return $this->redirectToRoute('login');

        endif;

        return $this->render('security/inscription.html.twig',[
            'formu'=>$form->createView()
        ]);

    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {

        return $this->render('security/connexion.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $this->addFlash('success','Merci de votre visiste, à bientôt');
        $this->redirectToRoute('home');
}





}

