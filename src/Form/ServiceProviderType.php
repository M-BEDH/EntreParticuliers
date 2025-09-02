<?php

namespace App\Form;

use App\Entity\ServiceProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ServiceProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('city')
            ->add('email')
            ->add('serviceOffered', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer l\'offre de service',
                    ]),
                ],
                'label' => 'Offre de service :',
                'required' => true,
            ])
            ->add('businessTrip', null, [
                'label' => 'Déplacement professionnel :',
                'required' => false,
            ])
            ->add('hourPrice', null, [
                'label' => 'Prix à l\'heure :',
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceProvider::class,
        ]);
    }
}
