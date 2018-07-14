<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Dto\EditFeaturedArticlesRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditFeaturedArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arrayOfArticleIds', CollectionType::class, [
                    'entry_type' => TextType::class,
                    'required' => false,
                    'label' => 'Wyróżnione artykuły'
                ]
            )
            ->add('save', SubmitType::class);
        $builder->get('arrayOfArticleIds')
            ->addModelTransformer(new CallbackTransformer(
                function ($arrayOfUuids) {
                    return array_map(function ($uuid) {
                        return (string)$uuid;
                    }, $arrayOfUuids);
                },
                function ($arrayOfStrings) {
                    return array_map(function ($string) {
                        return ($string == null) ? null : Uuid::fromString(trim($string));
                    }, $arrayOfStrings);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EditFeaturedArticlesRequest::class,
        ));
    }
}