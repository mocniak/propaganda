<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Dto\EditChartRequest;
use Propaganda\Domain\Entity\Chart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditChartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('columns', CollectionType::class, [
                'entry_type' => ColumnType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Column' => Chart::TYPE_COLUMN,
                    'Pie' => Chart::TYPE_PIE,
                    'Line' => Chart::TYPE_LINE,
                    'Bar' => Chart::TYPE_BAR,
                ]
            ])
            ->add('data', TextareaType::class)
            ->add('save', SubmitType::class);
        $builder->get('data')
            ->addModelTransformer(new CallbackTransformer(
                function ($dataAsArray) {
                    $temp_memory = fopen('php://memory', 'w');
                    foreach ($dataAsArray as $line) {
                        fputcsv($temp_memory, $line, ',', '\'');
                    }
                    fseek($temp_memory, 0);

                    return stream_get_contents($temp_memory);
                },
                function ($dataAsCSV) {
                    $dataAsArray = str_getcsv($dataAsCSV, "\n");
                    foreach ($dataAsArray as &$row) $row = str_getcsv($row, ",", '\'');

                    return $dataAsArray;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EditChartRequest::class,
        ));
    }
}