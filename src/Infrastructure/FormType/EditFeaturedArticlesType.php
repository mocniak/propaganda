<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Dto\EditFeaturedArticlesRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditFeaturedArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arrayOfArticleIds', TextareaType::class)
            ->add('save', SubmitType::class);
        $builder->get('arrayOfArticleIds')
            ->addModelTransformer(new CallbackTransformer(
                function ($array) {
                    return implode("\n", $array);
                },
                function ($string) {
                    $arrayOfStringIds = explode("\n", $string);
                    $arrayOfUUIDs = [];
                    foreach ($arrayOfStringIds as $stringId) {
                        $arrayOfUUIDs[] = Uuid::fromString(trim($stringId));
                    }
                    return $arrayOfUUIDs;
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