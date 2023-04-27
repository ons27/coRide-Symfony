<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\TypeReclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('text_rec', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('sujet', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('id_user', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('typeReclamation', EntityType::class, [
                'class' => TypeReclamation::class,
                'choice_label' => 'type_r',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
