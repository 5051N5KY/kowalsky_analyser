<?php

namespace App\Form;

use App\Entity\Fraction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fraction_name')
            ->add('fraction_description')
            ->add('date_created', null, [
                'widget' => 'single_text',
            ])
            ->add('date_modified', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fraction::class,
        ]);
    }
}
