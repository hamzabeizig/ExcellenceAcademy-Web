<?php

namespace App\Form;

use App\Entity\Assiduite;
use App\Entity\Matiere;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AssiduiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class)
            ->add('valeur',TextType::class)
            ->add('matiere',EntityType::class,['class' => Matiere::class,
                'choice_label' => 'nom_matiere',
                'label' => 'matiere'])
            ->add('User',EntityType::class,['class' => User::class,
                'choice_label' => 'user_name',
                'label' => 'user'])
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assiduite::class,
        ]);
    }
}
