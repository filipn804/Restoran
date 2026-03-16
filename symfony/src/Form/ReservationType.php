<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{
TextType, EmailType, DateType, TimeType, IntegerType, TextareaType, CheckboxType
};
use Symfony\Component\Form\FormBuilderInterface;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
        ->add('fullName',TextType::class)
        ->add('email',EmailType::class)
        ->add('phone',TextType::class)
        ->add('date',DateType::class)
        ->add('time',TimeType::class)
        ->add('partySize',IntegerType::class)
        ->add('specialRequests',TextareaType::class)
        ->add('privateDining',CheckboxType::class,['required'=>false]);
    }
}