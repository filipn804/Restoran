<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, ['label' => 'Full Name'])
            ->add('email', EmailType::class, ['label' => 'Email Address'])
            ->add('phone', TextType::class, ['label' => 'Phone Number'])
            ->add('date', DateType::class, ['label' => 'Reservation Date', 'widget' => 'single_text'])
            ->add('time', TimeType::class, ['label' => 'Reservation Time', 'widget' => 'single_text'])
            ->add('partySize', IntegerType::class, ['label' => 'Number of Guests'])
            ->add('specialRequest', TextareaType::class, ['label' => 'Special Request', 'required' => false]) 
            ->add('privateDining', CheckboxType::class, ['label' => 'Private Dining', 'required' => false])
            ->add('status', TextType::class, ['label' => 'Status', 'disabled' => true])
            ->add('referenceCode', TextType::class, ['label' => 'Reference Code', 'disabled' => true])
            ->add('createdAt', DateType::class, ['label' => 'Created At', 'widget' => 'single_text', 'disabled' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}