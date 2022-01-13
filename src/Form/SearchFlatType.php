<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class, [
                'label' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control input-search',
                    'placeholder' => 'Recherche un logement, une ville',
                    'required' => false,
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de logement',
                'choices'  => [
                    'Tous' => '',
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Loft' => 'Loft',
                    'Studio' => 'Studio'
                ],
                'attr' => [
                    'class' => 'form-select input-search',
                ],
            ])

            ->add('furnished', ChoiceType::class, [
                'label' => 'Equipement',
                'choices'  => [
                    'Indifférent' => '',
                    'Meublé' => 'yes',
                    'Non meublé' => 'no',
                    'Semi meublé' => 'half',
                ],
                'attr' => [
                    'class' => 'form-select input-search',
                ],
            ])
            // ->add('city')
            // ->add('surface')
            // ->add('rooms')
            // ->add('free_space')
            // ->add('total_space')
            // ->add('rent')
            // ->add('description')
            ->add('gender', ChoiceType::class, [
                'label' => 'Préférence',
                'choices'  => [
                    'Indifférent' => '',
                    'Colocation Masculine' => 'men',
                    'Colocation Féminine' => 'women',
                    'Colocation Mixte' => 'all',
                ],
                'attr' => [
                    'class' => 'form-select input-search',
                ],
            ])
            //->add('available')
            ->add('submit', SubmitType::class, [
                'label' => '<i class="fas fa-search"></i>',
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-global-search input-search',
                ]
            ])
        ;
        $builder->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
            'emptyQuery' => null,
        ]);
    }
}
