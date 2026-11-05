<?php

namespace App\DataFixtures;

use App\Entity\Artistes;
use App\Entity\Benevoles;
use App\Entity\Lieux;
use App\Entity\Oeuvres;
use App\Entity\Photos;
use App\Entity\Techniques;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
{
    $user = new User();
    $user->setEmail('user@test.com');
    $user->setRoles(['ROLE_USER']);
    $user->setPassword($this->hasher->hashPassword($user, '1234'));
    $manager->persist($user);

    $benevoleUser = new User();
    $benevoleUser->setEmail('benevole@test.com');
    $benevoleUser->setRoles(['ROLE_BENEVOLE']);
    $benevoleUser->setPassword($this->hasher->hashPassword($benevoleUser, '1234'));
    $manager->persist($benevoleUser);

    $benevole = new Benevoles();
    $benevole->setNom('Dupont');
    $benevole->setPrenom('Jean');
    $benevole->setEmail('jean.dupont@test.com'); // max 30 caractères
    $manager->persist($benevole);

    $lieu1 = new Lieux();
    $lieu1->setNom("Musée d'Art Moderne");
    $lieu1->setQuartier('Centre');
    $lieu1->setGps('48.86'); // NUMERIC(10,2) : une seule valeur décimale
    $manager->persist($lieu1);

    $tech1 = new Techniques();
    $tech1->setTechnique("Peinture à l'huile");
    $manager->persist($tech1);

    $artiste1 = new Artistes();
    $artiste1->setPseudo('Picasso');
    $artiste1->setNom('Pablo Picasso');
    $manager->persist($artiste1);

    $oeuvre1 = new Oeuvres();
    $oeuvre1->setTitre('Guernica');
    $oeuvre1->setDate(new \DateTime('1937-01-01'));
    $oeuvre1->setDescription('Grande toile en noir et blanc.');
    $oeuvre1->setLieux($lieu1);
    $oeuvre1->setTechnique($tech1);
    $oeuvre1->addArtiste($artiste1);
    $manager->persist($oeuvre1);

    $photo1 = new Photos();
    $photo1->setDate(new \DateTime());
    $photo1->setNomFichier('guernica.jpg');
    $photo1->setEtatOeuvre('Bon état');
    $photo1->setOeuvre($oeuvre1);
    $photo1->setBenevole($benevole);
    $manager->persist($photo1);

    $manager->flush();
}
}