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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AddFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', CheckboxType::class, [
                'label' => 'Type de logement',
                'mapped' => false,
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
            ->add('surface', NumberType::class,  [
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
            ->add('gender', CheckboxType::class, [
                'label' => 'Genre',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez choisir une option'
                    ])
                ]
            ])
            ->add('available', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ]
            ])
            ->add('images', FileType::class, [
                'label' => 'Image du logement',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k'
                    ])
                ]

            ])
            ->add('Zipcode', NumberType::class, [
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flat::class,
        ]);
    }
}
