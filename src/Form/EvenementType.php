<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region')
            ->add('description')
            ->add('datev', DateType::class, [
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Date Evenement',
                'required' => true,
                'data' => new \DateTime('+1 week'),
            ])
            ->add('titre')
            ->add('image')
            ->add('price')
            ->add('auteur')
            ->add('gouvernorat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
