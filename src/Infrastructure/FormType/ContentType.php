<?php

namespace Propaganda\Infrastructure\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', TextType::class);
        $builder->add('type', ChoiceType::class, [
            'choices' => [
                'Text' => 'text',
                'Image' => 'image',
                'youtubeVideo' => 'youtubeVideo',
            ]
        ]);
    }
}