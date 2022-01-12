<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'input-round',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            'max'=> 50,
                            'minMessage' => 'Votre mot de passe doit contenir minimum {{ limit }} caractères',
                            'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères',
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*?[@$!%*#?&])/',
                            'message' => 'Votre mot de passe doit contenir au minimum 1 chiffre, 1 lettre et 1 caractère spécial',
                        ]),
                        new NotCompromisedPassword([
                            'message' => 'Ce mot de passe semble avoir déjà été compromis lors d\'une fuite de donnée d\'un autre service.',
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'input-round',
                    ],
                    'label' => 'Retapez le nouveau mot de passe',
                ],
                'invalid_message' => 'Les deux mots de passe ne sont pas identique.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
