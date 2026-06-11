<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\TypeSalle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la salle',
            ])
            ->add('typeSalle', EntityType::class, [
                'class' => TypeSalle::class,
                'choice_label' => 'nom',
                'label' => 'Type de salle',
                'placeholder' => 'Choisissez un type',
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu',
            ])
            ->add('limitePlace', IntegerType::class, [
                'label' => 'Limite de places',
            ])
            ->add('status', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('tri', IntegerType::class, [
                'label' => 'Ordre de tri',
            ])
            ->add('miseEnAvant', CheckboxType::class, [
                'label' => 'Mise en avant',
                'required' => false,
            ])
            ->add('apercuFile', FileType::class, [
                'label' => 'Aperçu (photo)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, WEBP).',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}