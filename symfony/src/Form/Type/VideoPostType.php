<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\VideoPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Class VideoPostType
 */
class VideoPostType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('documentFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => true,
                'download_label' => '...',
                'download_uri' => true,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VideoPost::class,
        ]);
    }

}
