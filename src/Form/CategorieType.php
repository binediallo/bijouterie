<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['ajouter']==true):
        $builder
            ->add('nom',TextType::class ,[
                "required"=>false,
                "label"=>false,
                "attr"=>[
                    "placeholder"=>"Saisir le nom de la catégorie"
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
                "placeholder"=>"Entrez le nouveau nom de la catégorie"
            ]
        ])
            ->add('Valider',SubmitType::class, [

            ]);
        endif;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'ajouter'=>false,
            'modifier'=>false
        ]);
    }
}
