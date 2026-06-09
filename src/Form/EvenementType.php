<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('artiste')
            ->add('dateEvenement', DateType::class, [
                'widget' => 'single_text', // affiche uniquement un calendrier
            ])
            ->add('heureEvenement', TimeType::class, [
                'widget' => 'single_text', // affiche uniquement un champ horaire
            ])
            ->add('lieu')
            ->add('prixBillet')
            ->add('description')
            ->add('image')
            ->add('categorie')
            ->add('actif')
            // 'dateCreation' est retiré car il est défini automatiquement dans le constructeur
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
