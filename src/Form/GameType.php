<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Game;
use App\Entity\Platform;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<Game>
 */
class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['maxlength' => 100],
            ])
            ->add('platform', EntityType::class, [
                'label' => 'Plateforme',
                'class' => Platform::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une plateforme',
            ])
            ->add('picture', TextType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => ['maxlength' => 255],
            ])
            ->add('cover', TextType::class, [
                'label' => 'Couverture',
                'required' => false,
                'attr' => ['maxlength' => 255],
            ])
            ->add('finishedAt', DateType::class, [
                'label' => 'Date de fin',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('finishedTimes', IntegerType::class, [
                'label' => 'Nombre de fois terminé',
                'required' => false,
            ])
            ->add('isSearched', CheckboxType::class, [
                'label' => 'Recherché',
                'required' => false,
            ])
            ->add('isGameOfTheYear', CheckboxType::class, [
                'label' => 'Jeu de l\'année',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
