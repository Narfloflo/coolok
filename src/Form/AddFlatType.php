<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AddFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type de logement',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('furnished', CheckboxType::class, [
                'label' => 'Meublé ou non meublé',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez choisir une option.'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('surface', TextType::class,  [
                'label' => 'Surface du logement',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('rooms', NumberType::class, [
                'label' => 'Nombre de pieces',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('free_space')
            ->add('total_space')
            ->add('rent', NumberType::class, [
                'label' => 'Loyer',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du logement',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('gender')
            ->add('available')
            ->add('images')
            ->add('Zipcode', TextType::class, [
                'label' => 'Adresse du logement',
                'attr' => [
                    'classe' => 'input-round',
                ]
            ])
            ->add('owner', TextType::class, [
                'label' => 'Nom du proprietaire',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flat::class,
        ]);
    }
}
