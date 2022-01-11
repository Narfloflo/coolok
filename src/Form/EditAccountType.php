<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles')
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Camille',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un prénom'
                    ]),
                ],

            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Dupont',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un nom. (Il ne sera masqué sur votre profil publique.)'
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre emplacement',
                'attr' => [
                    'placeholder' => 'Paris',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir votre ville.'
                    ]),
                ],

            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'rows' => 5,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une présentation.'
                    ]),
                    new Length([
                        'min' => 10,
                        'max'=> 1000,
                        'minMessage' => 'Votre présentation doit contenir minimum {{ limit }} caractères',
                        'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],

            ])
            ->add('passions', TextType::class, [
                'attr' => [
                    'rows' => 2,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de préciser quelqu\'un de vos loisirs / passions'
                    ]),
                    new Length([
                        'min' => 3,
                        'max'=> 1000,
                        'minMessage' => 'Ce champ doit contenir minimum {{ limit }} caractères',
                        'maxMessage' => 'Ce champ doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],

            ])
            ->add('option_search', ChoiceType::class, [
                'label' => 'Vous recherchez ?',
                'choices'  => [
                    'Un logement' => 'un logement',
                    'Un(e) colocatair(e)' => 'un(e) colocatair(e)',
                    'Les deux' => 'un logement et des colocataires',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            // ->add('option_gender')
            // ->add('option_age_max')
            // ->add('option_age_min')
            // ->add('option_rent_min')
            // ->add('option_rent_max')
            ->add('picture', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required'=> is_null($builder->getData()->getId()),
                'attr' => [
                    'class' => 'form-control-file',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de transferer un fichier image valide',
                    ])
                ],
            ])
            ->add('available', ChoiceType::class, [
                'label' => 'Activer mon profil en ligne',
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'attr' => [
                    'class' => 'form-checklabel',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-outline-success',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
