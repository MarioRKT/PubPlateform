<?php

namespace App\Form;

use App\Entity\Menu;  // <-- Attention au namespace
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('status')
            ->add('typeLien', ChoiceType::class, [
                'choices' => [
                    'Événements'   => 'evenements',
                    'Catégories'   => 'categories',
                    // Ajoute d'autres types au fur et à mesure
                ],
                'placeholder' => 'Choisissez un type de lien',
                'required'    => true,
            ])
            // Si tu as ajouté le champ ordre, décommente la ligne suivante :
            // ->add('ordre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}