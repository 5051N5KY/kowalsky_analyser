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
            ->add('fraction_name', null, [
                'label' => 'Nazwa frakcji'
            ])
            ->add('fraction_description', null, [
                'label' => 'Opis frakcji'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fraction::class,
        ]);
    }
}
