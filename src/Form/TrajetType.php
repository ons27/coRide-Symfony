<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\TypeTrajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder



            ->add('depart', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('destination', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('typeTrajet', EntityType::class, [
                'class' => TypeTrajet::class,
                'choice_label' => 'typet',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
