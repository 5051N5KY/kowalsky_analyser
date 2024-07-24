<?php

namespace App\Form;

use App\Entity\Shperacze;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShperaczeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', null, [
                'label' => 'Ksywa'
            ])
            ->add('shper_number', null, [
                'label' => 'Numer'
            ])
            ->add('active', null, [
                'label' => 'Czy aktywny?'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shperacze::class,
        ]);
    }
}
