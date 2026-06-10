<?php

namespace App\Form;

use App\Entity\SiteConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SiteConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titrePage', TextType::class, [
                'label' => 'Titre du site',
                'required' => true,
            ])
            ->add('copyright', TextType::class, [
                'label' => 'Texte copyright',
            ])
            ->add('lienSiteWeb', TextType::class, [
                'label' => 'Lien du site web (URL)',
            ])
            ->add('activationPaiement', CheckboxType::class, [
                'label' => 'Activer le paiement',
                'required' => false,
            ])
            ->add('nbrMaxMenu', IntegerType::class, [
                'label' => 'Nombre maximum de menus',
                'required' => true,
            ])
            ->add('logoFile', FileType::class, [
                'label' => 'Logo (image)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide.',
                    ])
                ],
            ])
            ->add('faviconFile', FileType::class, [
                'label' => 'Favicon (image .ico ou .png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => ['image/x-icon', 'image/png', 'image/vnd.microsoft.icon'],
                        'mimeTypesMessage' => 'Veuillez télécharger un favicon valide.',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SiteConfig::class,
        ]);
    }
}