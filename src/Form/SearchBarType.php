<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('query', SearchType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Rechercher',
            ],
        ])
        // ->add('submit', SubmitType::class, [
        //     'label' => '<i class="fas fa-search"></i>',
        //     'label_html' => true,

        // ])
            // ->add('type')
            // ->add('furnished')
            // ->add('city')
            // ->add('surface')
            // ->add('rooms')
            // ->add('free_space')
            // ->add('total_space')
            // ->add('rent')
            // ->add('description')
            // ->add('gender')
            // ->add('available')
            // ->add('images')
            // ->add('owner')
        ;

        $builder->setMethod('GET');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Flat::class,
        ]);
    }
}
