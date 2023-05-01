<?php

namespace App\Form;

use App\Entity\Gouvernorat;

use App\Entity\Articleculturel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;







use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleCulturelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'name' => 'Titre',
                    // Ajoute la classe 'form-control' au champ
                    'id' => 'Titre', // Ajoute l'ID 'temps-moyenne-input' au champ
                    'type' => 'text', // Ajoute une valeur par défaut de 30 au champ
                    'placeholder' => 'Titre', // Ajoute un placeholder personnalisé au champ
                ],
                // Ajoutez d'autres options pour le champ ici
            ])
            ->add('tempMoyenne', IntegerType::class, [
                'attr' => [
                    'name' => 'TempsMoyenne',
                    // Ajoute la classe 'form-control' au champ
                    'id' => 'TempsMoyenne', // Ajoute l'ID 'temps-moyenne-input' au champ
                    'type' => 'number', // Ajoute une valeur par défaut de 30 au champ
                    'placeholder' => 'Temperature Moyenne', // Ajoute un placeholder personnalisé au champ
                ],
                // Ajoutez d'autres options pour le champ ici
            ])

            ->add('description', TextareaType::class, [
                'attr' => [
                    'name' => 'Description',
                    'cols' => '30',
                    'rows' => '4',
                    'placeholder' => 'Description',
                    // Ajoute la classe 'form-control' au champ
                    'id' => 'Description', // Ajoute l'ID 'temps-moyenne-input' au champ
                    // Ajoute une valeur par défaut de 30 au champ
                    // Ajoute un placeholder personnalisé au champ
                ],
                // Ajoutez d'autres options pour le champ ici
            ])

            ->add('idGouv', EntityType::class, [
                'label' => 'Gouvernorat',
                'class' => Gouvernorat::class,
                'choice_label' => 'nomGouver',
            ])

            ->add('image', FileType::class, [

                'label' => 'Image (JPG, PNG or GIF file)',
                'mapped' => false,
                'required' => false,

                'attr' => [
                    'onchange' => 'loadFile(event)'
                ],


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articleculturel::class,
        ]);
    }
}
