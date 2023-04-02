<?php

namespace App\Form;

use App\Entity\Poste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('trajet', ChoiceType::class, [
                'choices' => [
                    'traj1' => 'traj1',
                    'traj2' => 'traj2',
                    'traj3' => 'traj3',
                    'traj4' => 'traj4',
                    'traj5' => 'traj5',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('vehicule', ChoiceType::class, [
                'choices' => [
                    'v1' => 'v1',
                    'v2' => 'v2',
                    'v3' => 'v3',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('prix', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('depart', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('arrive', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}
