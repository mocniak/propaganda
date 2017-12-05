<?php

namespace Propaganda\Infrastructure\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', CollectionType::class, [
                'entry_type' => ContentType::class,
                'entry_options' => array('label' => false),
            ])
            ->add('save', SubmitType::class)
        ;
    }
}