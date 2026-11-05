<?php

namespace App\Form;

use App\Entity\Benevoles;
use App\Entity\Oeuvres;
use App\Entity\Photos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('nomFichier')
            ->add('etatOeuvre')
            ->add('commentaire')
            ->add('oeuvre', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'id',
            ])
            ->add('benevole', EntityType::class, [
                'class' => Benevoles::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photos::class,
        ]);
    }
}
