<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'Société',
                'required'=> true,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required'=> true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required'=> true,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['id' => 'address-input'],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'required'=> true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required'=> true,
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'choices-service'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // pas de DTO
        ]);
    }
}
