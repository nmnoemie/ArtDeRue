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
            ->add('oeuvre', EntityType::class, [
                'class' => Oeuvres::class,
                'choice_label' => 'titre',
                'label' => 'Œuvre existante',
                'required' => false,
            ])
            ->add('nouvelleOeuvre', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ou tapez le titre d\'une nouvelle œuvre',
                'attr' => ['placeholder' => 'Ex: La Nuit étoilée']
            ])
            ->add('benevole', EntityType::class, [
                'class' => Benevoles::class,
                'choice_label' => 'nom',
                'label' => 'Bénévole existant',
                'required' => false,
            ])
            ->add('nouveauBenevole', TextType::class, [
                'mapped' => false, 
                'required' => false,
                'label' => 'Ou tapez le nom d\'un nouveau bénévole',
                'attr' => ['placeholder' => 'Ex: Martin']
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPG, PNG)',
                'mapped' => false,
                'required' => true,
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $form->getData(); // L'objet Photos

            $nouveauNom = $form->get('nouveauBenevole')->getData();
            if ($nouveauNom) {
                $benevole = new Benevoles();
                $benevole->setNom($nouveauNom); 
                $data->setBenevole($benevole);
            }

            $nouveauTitre = $form->get('nouvelleOeuvre')->getData();
            if ($nouveauTitre) {
                $oeuvre = new Oeuvres();
                $oeuvre->setTitre($nouveauTitre);
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