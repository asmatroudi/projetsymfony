<?php

namespace App\Form;

use App\Entity\Activities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ActivitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('adresse')
            ->add('numContact')
            ->add('image')
            ->add('date', DateType::class, [
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Date Evenement',
                'required' => true,
                'data' => new \DateTime('+0 day'),
            ])
            ->add('type')
            ->add('price')
            ->add('auteur')
            ->add('gouvernorat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
        ]);
    }
}
