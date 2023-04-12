<?php

namespace App\Form;

use App\Entity\Poste;
use App\Entity\TypePublication;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

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
                    'tunis-ariana' => 'tunis-ariana',
                    'tunis-lac2' => 'tunis-lac2',
                    'ariana-tunis' => 'ariana-tunis',
                    'lac2-tunis' => 'lac2-tunis',
                    'tunis-sfax' => 'tunis-sfax',
                    'sfax-tunis' => 'sfax-tunis',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('vehicule', ChoiceType::class, [
                'choices' => [
                    'clio 4' => 'clio 4',
                    'kia rio' => 'kia rio',
                    'peugeot 308' => 'peugeot 308',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('prix', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('date_depart', DateTimeType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('date_arrive', DateTimeType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('typepost', EntityType::class, [
                'class' => TypePublication::class,
                'choice_label' => 'type',
                'attr' => ['class' => 'form-control'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
            'em' => null,
        ]);
    }
    
}

/*
   ->add('type', ChoiceType::class, [
                'choices' => [
                    'longTrajet' => 'longTrajet',
                    'cousTraget' => 'cousTraget',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            
    ->add('type', EntityType::class, [
                'class' => TypePublication::class,
                'choice_label' => 'type',
                'attr' => [ 'class' => 'form-control'],
            ]);
          
             ->add(
            'type', ChoiceType::class, [
            'choices' => $typeChoices,
            'attr' => [ 'class' => 'form-control'],
            ])
            
*/