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
            ->add('nickname')
            ->add('shper_number')
            ->add('date_created', null, [
                'widget' => 'single_text',
            ])
            ->add('date_modified', null, [
                'widget' => 'single_text',
            ])
            ->add('active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shperacze::class,
        ]);
    }
}
