<?php

namespace Propaganda\Infrastructure\FormType;

use Propaganda\Domain\Dto\EditEventRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventId', HiddenType::class)
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('date', DateTimeType::class, [
                'minutes' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55]
            ])
            ->add('save', SubmitType::class);
        $builder->get('eventId')
            ->addModelTransformer(new CallbackTransformer(
                function ($uuidId) {
                    return ($uuidId === null) ? null : $uuidId->toString();
                },
                function ($idAsString) {
                    return Uuid::fromString($idAsString);
                }
            ));
        $builder->get('date')
            ->addModelTransformer(new CallbackTransformer(
                function ($dateTimeImmutable) {
                    $dateTime = new \DateTime(null, $dateTimeImmutable->getTimezone());
                    $dateTime->setTimestamp($dateTimeImmutable->getTimestamp());
                    return $dateTime;
                },
                function ($dateTimeMutableDate) {
                    return \DateTimeImmutable::createFromMutable($dateTimeMutableDate);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EditEventRequest::class,
        ));
    }
}