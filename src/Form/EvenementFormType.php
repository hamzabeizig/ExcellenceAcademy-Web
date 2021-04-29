<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_evenement',TextType::class)
            ->add('date_evenement',DateType::class)
            ->add('responsable',TextType::class)
            ->add('description',TextType::class)
            ->add('id_user',TextType::class)
            ->add('nbr_place',TextType::class)
            ->add('categorie',EntityType::class,['class' => Categorie::class,
                'choice_label' => 'Name'  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
