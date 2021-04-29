<?php

namespace App\Form;

use App\Entity\SocieteP;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Societe',EntityType::class,['class' => SocieteP::class,
                'choice_label' => 'Nom'  ])
            ->add('Email_Societe',TextType::class
            )
            ->add('pays',CountryType::class,['alpha3'=>true])
            ->add('date_debut',DateType::class)
            ->add('date_fin',DateType::class)
            ->add('type_stage',ChoiceType::class,
                ['choices'  => [
        'Pfe' => "Pfe",
        'Eté' => "Eté",
        'Ouvrier' => "Ouvrier",
                    'Initiation' => "Initiation",

                ],]    );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
