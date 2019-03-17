<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\PostLive;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostLiveType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'form.field.title',
                ],
                'label' => false,
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'form.field.content',
                ],
                'label' => false,
            ])
            ->add('stream', TextType::class, [
                'attr' => [
                    'placeholder' => 'Stream ID',
                ],
                'label' => false,
            ])
            ->add('streamApp', TextType::class, [
                'attr' => [
                    'placeholder' => 'Stream App',
                ],
                'label' => false,
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostLive::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
