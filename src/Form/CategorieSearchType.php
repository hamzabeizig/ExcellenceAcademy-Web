<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\CategorieSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Categorie',EntityType::class,['class' => Categorie::class,
                'choice_label' => 'Name' ,
                'label' => 'Catégorie' ]);        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategorieSearch::class,
        ]);
    }
}
