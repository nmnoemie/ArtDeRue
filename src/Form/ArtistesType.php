<?php

namespace App\Form;

use App\Entity\Artistes;
use App\Entity\Oeuvres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('nom')
            ->add('bio')
            ->add('nationalite')
            ->add('Oeuvres', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Œuvres associées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artistes::class,
        ]);
    }
}
