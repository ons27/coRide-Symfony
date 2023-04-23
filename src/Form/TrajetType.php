<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'composee' => 'composee',
                ],
                'attr' => [ 'class' => 'form-control'],
            ])
            
            ->add('depart', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
            ->add('destination', TextType::class,[
                'attr' => [ 'class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
