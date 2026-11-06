<?php

namespace App\Form;

use App\Entity\Benevoles;
use App\Entity\Oeuvres;
use App\Entity\Photos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('etatOeuvre')
            ->add('commentaire')
            // Liste déroulante des œuvres existantes
            ->add('oeuvre', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'titre',
                'label' => 'Œuvre existante',
                'required' => false,
            ])
            // Champ texte pour créer une nouvelle œuvre
            ->add('nouvelleOeuvre', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ou tapez le titre d\'une nouvelle œuvre',
                'attr' => ['placeholder' => 'Ex: La Nuit étoilée']
            ])
            // Liste déroulante des bénévoles existants
            ->add('benevole', EntityType::class, [
                'class' => Benevoles::class,
                'choice_label' => 'nom',
                'label' => 'Bénévole existant',
                'required' => false,
            ])
            // Champ texte pour créer un nouveau bénévole
            ->add('nouveauBenevole', TextType::class, [
                'mapped' => false, 
                'required' => false,
                'label' => 'Ou tapez le nom d\'un nouveau bénévole',
                'attr' => ['placeholder' => 'Ex: Martin']
            ])
            // Champ pour l'image
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPG, PNG)',
                'mapped' => false,
                'required' => true,
            ])
        ;

        // Événement pour gérer la création à la volée
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $form->getData(); // L'objet Photos

            // 1. Gestion du nouveau Bénévole
            $nouveauNom = $form->get('nouveauBenevole')->getData();
            if ($nouveauNom) {
                $benevole = new Benevoles();
                $benevole->setNom($nouveauNom); 
                $data->setBenevole($benevole);
            }

            // 2. Gestion de la nouvelle Œuvre
            $nouveauTitre = $form->get('nouvelleOeuvre')->getData();
            if ($nouveauTitre) {
                $oeuvre = new Oeuvres();
                $oeuvre->setTitre($nouveauTitre);
                // Si votre entité Oeuvres a d'autres champs obligatoires (date...), 
                // il faudra les définir ici aussi.
                $data->setOeuvre($oeuvre);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photos::class,
        ]);
    }
}