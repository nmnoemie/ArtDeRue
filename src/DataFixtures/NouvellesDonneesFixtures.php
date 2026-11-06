<?php

namespace App\DataFixtures;

use App\Entity\Artistes;
use App\Entity\Benevoles;
use App\Entity\Lieux;
use App\Entity\Oeuvres;
use App\Entity\Photos;
use App\Entity\Techniques;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class NouvellesDonneesFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['nouvelles_donnees'];
    }

    public function load(ObjectManager $manager): void
    {
        $lieu1 = new Lieux(); 
        $lieu1->setNom('Friche Belle de Mai'); 
        $lieu1->setQuartier('Marseille'); 
        $lieu1->setGps('43.3025, 5.3925'); // <-- Ajout du GPS
        $manager->persist($lieu1);

        $lieu2 = new Lieux(); 
        $lieu2->setNom('Le MUR'); 
        $lieu2->setQuartier('Paris 18e'); 
        $lieu2->setGps('48.8867, 2.3444'); // <-- Ajout du GPS
        $manager->persist($lieu2);

        $lieu3 = new Lieux(); 
        $lieu3->setNom('Mauerpark'); 
        $lieu3->setQuartier('Berlin'); 
        $lieu3->setGps('52.5417, 13.4016'); // <-- Ajout du GPS
        $manager->persist($lieu3);

        $lieu4 = new Lieux(); 
        $lieu4->setNom('Mur des Canuts'); 
        $lieu4->setQuartier('Lyon'); 
        $lieu4->setGps('45.7719, 4.8278'); // <-- Ajout du GPS
        $manager->persist($lieu4);

        $tech1 = new Techniques(); $tech1->setTechnique('Bombe aérosol et acrylique');
        $tech2 = new Techniques(); $tech2->setTechnique('Peinture en aérosol (Noir & Blanc)');
        $tech3 = new Techniques(); $tech3->setTechnique('Graffiti sauvage (Wildstyle)');
        $tech4 = new Techniques(); $tech4->setTechnique('Peinture à l\'huile et aérosol');
        $manager->persist($tech1); $manager->persist($tech2); $manager->persist($tech3); $manager->persist($tech4);

        $artiste1 = new Artistes(); $artiste1->setNom('Miss.Tic'); $artiste1->setPseudo('Miss.Tic'); $artiste1->setNationalite('Française');
        $artiste2 = new Artistes(); $artiste2->setNom('JR'); $artiste2->setPseudo('JR'); $artiste2->setNationalite('Français');
        $artiste3 = new Artistes(); $artiste3->setNom('Banksy'); $artiste3->setPseudo('Banksy'); $artiste3->setNationalite('Britannique');
        $artiste4 = new Artistes(); $artiste4->setNom('Seth'); $artiste4->setPseudo('Seth'); $artiste4->setNationalite('Français');
        $manager->persist($artiste1); $manager->persist($artiste2); $manager->persist($artiste3); $manager->persist($artiste4);

        $oeuvre1 = new Oeuvres();
        $oeuvre1->setTitre('La Belle Électrique');
        $oeuvre1->setDate(new \DateTime('2023-03-15'));
        $oeuvre1->setDescription('Portrait stylisé d\'une femme aux cheveux flamboyants.'); // <-- Ajout
        $oeuvre1->setLieux($lieu1);
        $oeuvre1->setTechnique($tech1);

        $oeuvre2 = new Oeuvres();
        $oeuvre2->setTitre('Le Regard de la Rue');
        $oeuvre2->setDate(new \DateTime('2022-06-22'));
        $oeuvre2->setDescription('Un œil géant hyperréaliste qui observe les passants.'); // <-- Ajout
        $oeuvre2->setLieux($lieu2);
        $oeuvre2->setTechnique($tech2);

        $oeuvre3 = new Oeuvres();
        $oeuvre3->setTitre('Explosion Chromatique');
        $oeuvre3->setDate(new \DateTime('2023-09-10'));
        $oeuvre3->setDescription('Un mélange de formes géométriques et de couleurs vives.'); // <-- Ajout
        $oeuvre3->setLieux($lieu3);
        $oeuvre3->setTechnique($tech3);

        $oeuvre4 = new Oeuvres();
        $oeuvre4->setTitre('Le Sage');
        $oeuvre4->setDate(new \DateTime('2024-01-05'));
        $oeuvre4->setDescription('Portrait d\'un homme âgé avec une expression pensive.'); // <-- Ajout
        $oeuvre4->setLieux($lieu4);
        $oeuvre4->setTechnique($tech4);
        $benevole = $manager->getRepository(Benevoles::class)->findOneBy([]); 
        
        if (!$benevole) {
            $benevole = new Benevoles();
            $benevole->setNom('Dupont');
            $benevole->setPrenom('Jean');
            $manager->persist($benevole);
        }

        $photo1 = new Photos();
        $photo1->setDate(new \DateTime('2023-03-15'));
        $photo1->setNomFichier('art1.jpg'); 
        $photo1->setEtatOeuvre('Bon état');
        $photo1->setCommentaire('Portrait stylisé d\'une femme aux cheveux flamboyants.');
        $photo1->setOeuvre($oeuvre1);
        $photo1->setBenevole($benevole);
        $manager->persist($photo1);

        $photo2 = new Photos();
        $photo2->setDate(new \DateTime('2022-06-22'));
        $photo2->setNomFichier('art2.jpg');
        $photo2->setEtatOeuvre('Bon état');
        $photo2->setCommentaire('Un œil géant hyperréaliste qui observe les passants.');
        $photo2->setOeuvre($oeuvre2);
        $photo2->setBenevole($benevole);
        $manager->persist($photo2);

        $photo3 = new Photos();
        $photo3->setDate(new \DateTime('2023-09-10'));
        $photo3->setNomFichier('art3.jpg'); 
        $photo3->setEtatOeuvre('Excellent état');
        $photo3->setCommentaire('Un mélange de formes géométriques et de couleurs vives.');
        $photo3->setOeuvre($oeuvre3);
        $photo3->setBenevole($benevole);
        $manager->persist($photo3);

        $photo4 = new Photos();
        $photo4->setDate(new \DateTime('2024-01-05'));
        $photo4->setNomFichier('art4.jpg'); 
        $photo4->setEtatOeuvre('Bon état');
        $photo4->setCommentaire('Portrait d\'un homme âgé avec une expression pensive.');
        $photo4->setOeuvre($oeuvre4);
        $photo4->setBenevole($benevole);
        $manager->persist($photo4);

        $manager->flush();
    }
}