<?php

namespace BlogBundle\Form;

use Symfony\Component\Validator\Constraints\File;


use BlogBundle\Entity\Post as Post;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;


class ImagePostType extends TextPostType
{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $form = parent::buildForm($builder, $options);

        $form
            ->remove('content')
            ->add('content', Type\FileType::class, array(
                'base64' => True,
                'required' => True,
                'constraints' => array(
                    'file' => new File( array(
                        'maxSize' => '20M',
                        'mimeTypes' => array(
                            'image/png',
                            'image/jpeg',
                            'image/gif'
                        )
                    ))
                )
            ))
            ->remove('type')
            ->add('type', Type\ChoiceType::class, array(
                'choices' => array(
                    Post::IMAGE_POST_DISCRIMINATOR,
                )
            ))
        ;

        return $form;
    }
}