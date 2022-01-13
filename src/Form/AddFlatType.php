<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type de logement',
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Loft' => 'Loft',
                    'Studio' => 'Studio'
                ],
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('furnished', ChoiceType::class, [
                'label' => 'Le Logement est-il meublé ?',
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                    'Semi-meublé' => 'half',
                ],
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('city', HiddenType::class, [
            ])
            ->add('surface', NumberType::class,  [
                'label' => 'Surface du logement (en m2)',
                'attr' => [
                    'class' => 'input-round',
                    'placeholder' => '85'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une surface'
                    ]),
                ],
            ])
            ->add('rooms', NumberType::class, [
                'label' => 'Nombre de pièces',
                'attr' => [
                    'class' => 'input-round',
                    'placeholder' => '6'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un nombre'
                    ]),
                ],
            ])
            ->add('free_space', NumberType::class, [
                'label' => 'Chambres disponibles',
                'attr' => [
                    'class' => 'input-round',
                    'placeholder' => '2'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un nombre'
                    ]),
                ],
            ])
            ->add('total_space', NumberType::class, [
                'label' => 'Nombre total de personne',
                'attr' => [
                    'class' => 'input-round',
                    'placeholder' => '3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un nombre'
                    ]),
                ],
            ])
            ->add('rent', NumberType::class, [
                'label' => 'Loyer par personne (€)',
                'attr' => [
                    'class' => 'input-round',
                    'placeholder' => '400'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un loyer'
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du logement',
                'attr' => [
                    'class' => 'input-round',
                    'rows' => 6,
                    'placeholder' => 'Décrivez ici le logement et la colocation.'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir une description.'
                    ]),
                    new Length([
                        'min' => 10,
                        'max'=> 1000,
                        'minMessage' => 'Votre description doit contenir minimum {{ limit }} caractères',
                        'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Type de colocation',
                'choices' => [
                    '100% masculine' => 'men',
                    '100% féminine' => 'women',
                    'Mixte' => 'all'
                ],
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('available', ChoiceType::class, [
                'label' => 'Mettre en ligne le logement ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'attr' => [
                    'class' => 'input-round',
                ]
            ])
            ->add('images', FileType::class, [
                'label' => 'Image du logement',
                'mapped' => false,
                'required' => true,
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
            ->add('zipcode', HiddenType::class, [
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
