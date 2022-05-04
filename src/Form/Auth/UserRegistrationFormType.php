<?php
namespace App\Form\Auth;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName',TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'me-2 fw-bold'
                ],
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder'=> 'Saisir votre nom',
                ],
            ])
            ->add('firstName',TextType::class, [
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'me-2 fw-bold'
                ],
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder'=> 'Saisir votre prénom',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'me-2 fw-bold'
                ],
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder'=> 'Saisir votre email',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'placeholder'=> 'Choisissez un mot de passe',
                    ],

                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'me-2 fw-bold'
                    ],
                    'help' => '8 caractères minimun, 1 majuscule, 1 minuscule, 1 chiffre',
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder'=> 'Confirmez votre mot de passe',
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'me-2 fw-bold'
                    ],
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}