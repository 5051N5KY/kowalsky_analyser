<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Fraction;
use App\Entity\ScannedObject;
use App\Entity\Shperacze;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScannedObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo_path')
            ->add('pdf_path')
            ->add('name')
            ->add('general_description')
            ->add('background_description')
            ->add('analysis_result')
            ->add('who_brought_object_name_id')
            ->add('shper_id', EntityType::class, [
                'class' => Shperacze::class,
                'choice_label' => 'id',
            ])
            ->add('event_id', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'id',
            ])
            ->add('item_possession_id', EntityType::class, [
                'class' => Fraction::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScannedObject::class,
        ]);
    }
}
