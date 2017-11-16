<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Dto\EditArticleRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articleId', HiddenType::class)
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class);
        $builder->get('articleId')
            ->addModelTransformer(new CallbackTransformer(
                function ($uuidId) {
                    return ($uuidId === null) ? null : $uuidId->toString();
                },
                function ($idAsString) {
                    return Uuid::fromString($idAsString);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EditArticleRequest::class,
        ));
    }
}