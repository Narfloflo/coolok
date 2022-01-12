<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => 'input-round',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une adresse email.'
                    ]),
                    new Email([
                        'message' => 'Vous devez saisir une adresse email valide'
                    ]),
                ]

            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'input-round',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un mot de passe.'
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
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('cgu', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales d\'utilisation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos CGU'
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-validate',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
