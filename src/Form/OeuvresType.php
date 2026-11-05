<?php

namespace App\Form;

use App\Entity\Artistes;
use App\Entity\Lieux;
use App\Entity\Oeuvres;
use App\Entity\Techniques;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('date')
            ->add('description')
            ->add('Artistes', EntityType::class, [
                'class' => Artistes::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Artistes'
            ])
            ->add('Lieux', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom',
                'label' => 'Lieux'
            ])
            ->add('technique', EntityType::class, [
                'class' => Techniques::class,
                'choice_label' => 'technique',
                'label'=> 'technique'
            ])
            ->add('recouvre', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'titre',
                'required' => false,
                'label' => 'Recouvre'
            ])
            ->add('recouvertePar', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'titre',
                'required' => false,
                'label' => 'Recouverte par'
            ])

            ->add('nouveauLieu', TextType::class, [
                'mapped' => false, 
                'required' => false,
                'label' => 'Ou ajoutez un nouveau lieu :',
                'attr' => ['placeholder' => 'Nom du nouveau lieu']

            ])
            ->add('nouvelleTechnique', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ou ajoutez une nouvelle technique :',
                'attr' => ['placeholder' => 'Nom de la nouvelle technique']
               ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvres::class,
        ]);
    }
}
