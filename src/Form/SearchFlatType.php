<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                'attr' => [
                    'placeholder' => 'Recherche un logement, une ville',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de logement',
                'choices'  => [
                    'Tous' => 'Appartement' || 'Maison' || 'Loft',
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Loft' => 'Loft',
                ],
                'attr' => [
                    'class' => '',
                ],
            ])
            ->add('furnished', ChoiceType::class, [
                'label' => 'Equipement',
                'choices'  => [
                    'Indifférent' => 'yes' || 'no' || 'half',
                    'Meublé' => 'yes',
                    'Non meublé' => 'no',
                    'Semi meublé' => 'half',
                ],
                'attr' => [
                    'class' => '',
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
                'label' => 'Vous recherchez une colocation',
                'choices'  => [
                    'Indifférent' => 'men' || 'women' || 'all',
                    'Masculine' => 'men',
                    'Féminine' => 'women',
                    'Mixte' => 'all',
                ],
                'attr' => [
                    'class' => '',
                ],
            ])
            //->add('available')
            ->add('submit', SubmitType::class, [
                'label' => '<i class="fas fa-search"></i>',
                'label_html' => true,
                'attr' => [
                    'class' => 'button',
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
