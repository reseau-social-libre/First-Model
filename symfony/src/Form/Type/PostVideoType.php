<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\PostVideo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PostVideoType
 */
class PostVideoType extends AbstractType
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
            ->add('videos', CollectionType::class, array(
                    'label' => false,
                    'entry_type'    => VideoPostType::class,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                ))
            ;
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostVideo::class,
        ]);
    }

}
