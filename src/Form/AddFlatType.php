<?php

namespace App\Form;

use App\Entity\Flat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddFlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('furnished')
            ->add('city')
            ->add('surface')
            ->add('rooms')
            ->add('free_space')
            ->add('total_space')
            ->add('rent')
            ->add('description')
            ->add('gender')
            ->add('available')
            ->add('images')
            ->add('Zipcode')
            ->add('owner')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flat::class,
        ]);
    }
}
