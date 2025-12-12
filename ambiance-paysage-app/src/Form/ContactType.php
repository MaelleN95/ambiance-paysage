<?php

namespace App\Form;

use App\Entity\Service;
use App\Validator\Constraints\AtLeastOneContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'form.contact.company',
                'required'=> true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 1, 'max' => 100]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'form.contact.first_name',
                'required'=> true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\Regex('/^[\p{L}\s-]+$/u'),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'form.contact.last_name',
                'required'=> true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\Regex('/^[\p{L}\s-]+$/u'),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'form.contact.address',
                'attr' => ['id' => 'address-input'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5, 'max' => 255]),
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'form.contact.phone',
                'required'=> false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^0[1-9](\d{2}){4}$/',
                        'message' => 'Numéro de téléphone français invalide.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.contact.email',
                'required'=> false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['max' => 180]),
                ],
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'label' => 'form.contact.service',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'choices-service'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Count(['min' => 1]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.contact.message',
                'constraints' => [
                    new Assert\Length(['max' => 4000]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new AtLeastOneContact(),
            ],
            'data_class' => null,
        ]);
    }
}
