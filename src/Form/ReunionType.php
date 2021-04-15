<?php

namespace App\Form;

use App\Entity\Reunion;
use App\Entity\Departement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReunionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('date')
            ->add('matiere')
            ->add('objectif')
            ->add('horaire')
            ->add('departement',EntityType::class,['class' => Departement::class,
                'choice_label' => 'nom',
                'label' => 'Département']);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reunion::class,
        ]);
    }
}
