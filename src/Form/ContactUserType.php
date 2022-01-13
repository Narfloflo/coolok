<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('message', TextareaType::class, [
            'label' => 'Votre message :',
            'attr' => [
                'rows' => 5,
                'class' => 'form-control',
                'placeholder' => 'Tapez votre message ici (minimum 10 caractères)'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Vous devez saisir un message'
                ]),
                new Length([
                    'min' => 10,
                    'max'=> 1000,
                    'minMessage' => 'Votre message doit contenir minimum {{ limit }} caractères',
                    'maxMessage' => 'Votre message doit contenir au maximum {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer le message',
            'attr' => [
                'class' => 'mt-3 btn-validate',
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
