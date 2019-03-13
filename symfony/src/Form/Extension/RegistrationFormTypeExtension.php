<?php

declare(strict_types=1);

namespace App\Form\Extension;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class RegistrationFormTypeExtension
 */
class RegistrationFormTypeExtension extends AbstractTypeExtension
{

    /**
     * @return iterable
     */
    public static function getExtendedTypes(): iterable
    {
        return [
            RegistrationFormType::class,
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('email', EmailType::class,
                [
                    'label' => false,
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => [
                        'placeholder' => 'form.email',
                    ],
                ]
            )
            ->add('username', EmailType::class,
                [
                    'label' => false,
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => [
                        'placeholder' => 'form.username',
                    ],
                ]
            )
            ->add('plainPassword', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'options' => [
                        'translation_domain' => 'FOSUserBundle',
                        'attr' => [
                            'autocomplete' => 'new-password',
                        ],
                        'label' => false,
                        'constraints' => new Length(['min' => 8])
                    ],
                    'first_options' => [
                        'attr' => [
                            'placeholder' => 'form.password',
                        ]
                    ],
                    'second_options' => [
                        'attr' => [
                            'placeholder' => 'form.password_confirmation',
                        ]
                    ],
                    'invalid_message' => 'fos_user.password.mismatch',
                ]
            )
            ->add('termsAccepted', CheckboxType::class,
                [
                    'label' => 'Term and conditions',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => new IsTrue(['message' => 'Veuillez prendre connaissance et accepter les CGU']),
                ]
            )
        ;
    }


}