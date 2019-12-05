<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class, $this->getConfig("Date d'arrivée", "La date à laquelle vous entrerez dans le logement",["widget" =>"single_text" ]))
            ->add('endDate', DateType::class, $this->getConfig("Date de départ", "La date à laquelle vous quitterez le logement",["widget" =>"single_text" ]))
            ->add('comment', TextareaType::class, $this->getConfig(false, "Faites nous part de toutes informations supplémentaires", ["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
