<?php

namespace App\Form;

use App\Entity\Flight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Jour de départ',
                'attr' => [
                    'class' => ' my-2'
                ]
            ])
            ->add('departureTime', TimeType::class, [
                'label' => 'Heure de départ',
                'attr' => [
                    'class' => ' my-2'
                ]
            ])
            ->add('departureCity', TextType::class, [
                'label' => 'Ville de départ',
                'attr' => [
                    'class' => 'my-2'
                ]
                ])

            ->add('arrivalDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Jour d\'arrivée',
                'attr' => [
                    'class' => 'my-2'
                ]
            ])
            ->add('arrivalTime', TimeType::class, [
                'label' => 'Heure d\'arrivée',
                'attr' => [
                    'class' => 'my-2'
                ]
            ])
            ->add('arrivalCity', TextType::class, [
                'label' => 'Ville d\'arrivée',
                'attr' => [
                    'class' => ' my-2'
                ]
                ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'my-2'
                ]
            ])
            ->add('discount', CheckboxType::class, [
                'required' => false,
                'label' => 'Réduction'
            ])
            ->add('seatsNumber', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => [
                    'class' => 'my-2'
                ]           
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flight::class,
        ]);
    }
}
