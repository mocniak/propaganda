<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Entity\Chart\Column;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('type', ChoiceType::class, [
            'choices' => [
                'Number' => Column::NUMBER_TYPE,
                'Text' => Column::STRING_TYPE
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Column::class,
        ));
    }
}