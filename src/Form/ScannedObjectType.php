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
            ->add('name', null, [
                'label' => 'Nazwa'
            ])
            ->add('general_description', null, [
                'label' => 'Opis główny'
            ])
            ->add('background_description', null, [
                'label' => 'Opis tła'
            ])
            ->add('analysis_result', null, [
                'label' => 'Wynik analizy'
            ])
            ->add('who_brought_object_name_id', null, [
                'label' => 'Kto przyniósł'
            ])
            ->add('shper_id', EntityType::class, [
                'label' => 'Kto wprowadza?',
                'class' => Shperacze::class,
                'choice_label' => 'nickname',
            ])
            ->add('event_id', EntityType::class, [
                'label' => 'Impreza',
                'class' => Event::class,
                'choice_label' => 'event_name',
            ])
            ->add('item_possession_id', EntityType::class, [
                'label' => 'Gdzie znajduje się przedmiot?',
                'class' => Fraction::class,
                'choice_label' => 'fraction_name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScannedObject::class,
        ]);
    }
}
