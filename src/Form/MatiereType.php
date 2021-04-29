<?php


namespace App\Form;



use App\Entity\Matiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomMatiere')
            ->add('coefficient')
            ->add('volumeH')
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
        ]);
    }
}