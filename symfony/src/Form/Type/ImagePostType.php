<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\ImagePost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class ImagePostType
 */
class ImagePostType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('documentFile', VichImageType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_label' => '...',
                'download_uri' => false,
                'image_uri' => 'uploads/post/images/',
                'imagine_pattern' => 'post_image',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImagePost::class,
        ]);
    }

}
