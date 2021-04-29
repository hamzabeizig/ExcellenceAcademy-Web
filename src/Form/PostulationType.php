<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Email_Societe',TextType::class)
            ->add('pays',TextType::class)
            ->add('date_debut',TextType::class)
            ->add('date_fin',TextType::class)
            ->add('type_stage',TextType::class)
            ->add('Societe',TextType::class)
            ->add('CV',FileType::class,[ "mapped" => false])
            ->add('Lettre_de_motivation',FileType::class,[ "mapped" => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
