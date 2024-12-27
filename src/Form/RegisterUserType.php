<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::Class, [
                'label'=> "Prénom",
                'attr'=> [
                    'placeholder'=> "Votre prénom"
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 25,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre prénom ne peut contenir que des lettres.',
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Nom",
                'attr'=> [
                    'placeholder' => "Votre nom de famille",
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 25,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre prénom ne peut contenir que des lettres.',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=> "Email",
                'attr'=> [
                    'placeholder'=> "Votre adresse email"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options'  => [
                'label' => 'Votre mot de passe',
                'hash_property_path' => 'password',
                'attr'=> [
                    'placeholder' => "Votre mot de passe"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 32,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, et un caractère spécial.',
                    ]),
                ]
            ],
            'second_options' => [
                'label' => 'Confirmez votre mot de passe',
                'attr'=> [
                    'placeholder' => "Confirmez votre mot de passe"
                ]
            ],
            'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label'=> "S'inscrire",
                'attr'=> [
                    'class' => "btn btn-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email',
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
