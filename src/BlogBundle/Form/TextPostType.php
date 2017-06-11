<?php

namespace BlogBundle\Form;

use BlogBundle\Entity\Post as Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TextPostType extends AbstractType
{

    private $tagEntityClass;

    public function __construct($tagEntityClass){
        $this->tagEntityClass = $tagEntityClass;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return \Symfony\Component\Form\FormInterface
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('title', Type\TextType::class, array('required'=>True))
            ->add('content', Type\TextareaType::class, array('required'=>True))
            ->add('type', Type\ChoiceType::class, array(
                'choices' => array(
                    Post::TEXT_POST_DISCRIMINATOR,
                    Post::QUOTATION_POST_DISCRIMINATOR
                ),
                'mapped'=>false
            ))
            ->add('tags', EntityType::class, array(
                'class'=>$this->tagEntityClass,
                'choice_label' => 'name',
                'multiple' => true
            ))
            ->getForm()
        ;
    }
}