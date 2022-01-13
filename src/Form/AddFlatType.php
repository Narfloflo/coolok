<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AddFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type de logement',
                'choices' => [
                    'Studio' => 'Studio',
                    'Loft' => 'Loft',
                    'Maison' => 'Maison'
                ]
            ])
            ->add('furnished', ChoiceType::class, [
                'label' => 'Le Logement est-il meublé ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
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
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Mixte' => 'Mixte'
                ]
            ])
            ->add('available', ChoiceType::class, [
                'label' => 'Le logement est-il disponible ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
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
                'label' => 'Code Postal',
                'attr' => [
                    'classe' => 'input-round',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn-validate',
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
