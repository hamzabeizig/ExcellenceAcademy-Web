<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Matiere;
use App\Entity\MatiereSearch1;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class MatiereSearchType1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matiere',EntityType::class,['class' => Matiere::class, 'choice_label' => 'nom_matiere' , 'label' => 'Matiere' ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatiereSearch1::class,
        ]);
    }
}
