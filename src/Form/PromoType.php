<?php

namespace App\Form;

use App\Entity\Promo;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['ajouter']==true):
            $builder
                ->add('nom',TextType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('remise',NumberType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('montantmin',NumberType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('Valider',SubmitType::class, [

                ]);
        elseif ($options['modifier']==true):
            $builder
                ->add('nom',TextType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('remise',NumberType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('montantmin',NumberType::class ,[
                    "required"=>false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom de la promotion"
                    ]
                ])
                ->add('Valider',SubmitType::class, [

                ]);
        endif;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
            'ajouter'=>false,
            'modifer'=>false
        ]);
    }
}
