<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1;$i<11;$i++):
            $article=new Article(); // Ici on instancie un nouvel objet article hérité de la class App\entity\Article à chaque tour de boucle, pour autant d'article instancié, il y aura un insert supplémentaire en BDD
            $article->setNom("Article N°".$i)
                    ->setPrix(rand(100,400))
                    ->setDateCrea(new \DateTime())
                    ->setRef("ref".$i)
                    ->setPhoto("https://picsum.photos/600/".$i);
       // Ici on habille nos objets nu, instanciés précédement" avec les setter de nos différentes propriétés hérités de notre objet Article entity
                $manager->persist($article); // persist est une méthode issue de la class object manager qui permet de garder en mémoire les objet articles crées précédement et de préparer et binder les requetes avant insertion
        endfor;
        $manager->flush();
        // flush est une méthode de objectmanager qui permet d'exécuter les requetes préparées lors du persist() et permet ainsi les inserts en BDD

        // Une fius réalisé, il faut changer les Fixtures en BDD grace à DOCTRINE avec la commande suivante : php bin/console doctrine:fixtures:load
    }
}
