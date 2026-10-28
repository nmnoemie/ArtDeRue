<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261028162733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artistes (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(30) NOT NULL, nom VARCHAR(30) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, nationalite VARCHAR(30) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE artistes_oeuvres (artistes_id INT NOT NULL, oeuvres_id INT NOT NULL, INDEX IDX_1C7642ED96E1EAF4 (artistes_id), INDEX IDX_1C7642ED4928CE22 (oeuvres_id), PRIMARY KEY (artistes_id, oeuvres_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE benevoles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(30) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(50) DEFAULT NULL, quartier VARCHAR(20) NOT NULL, gps NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvres (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, date DATE NOT NULL, description LONGTEXT NOT NULL, lieux_id INT NOT NULL, technique_id INT NOT NULL, recouvre_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_413EEE3EE3E32370 (recouvre_id), INDEX IDX_413EEE3EA2C806AC (lieux_id), INDEX IDX_413EEE3E1F8ACB26 (technique_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, nom_fichier VARCHAR(30) NOT NULL, etat_oeuvre VARCHAR(30) NOT NULL, commentaire LONGTEXT DEFAULT NULL, oeuvre_id INT NOT NULL, benevole_id INT NOT NULL, INDEX IDX_876E0D988194DE8 (oeuvre_id), INDEX IDX_876E0D9E77B7C09 (benevole_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE techniques (id INT AUTO_INCREMENT NOT NULL, technique VARCHAR(30) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE artistes_oeuvres ADD CONSTRAINT FK_1C7642ED96E1EAF4 FOREIGN KEY (artistes_id) REFERENCES artistes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artistes_oeuvres ADD CONSTRAINT FK_1C7642ED4928CE22 FOREIGN KEY (oeuvres_id) REFERENCES oeuvres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3EA2C806AC FOREIGN KEY (lieux_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3E1F8ACB26 FOREIGN KEY (technique_id) REFERENCES techniques (id)');
        $this->addSql('ALTER TABLE oeuvres ADD CONSTRAINT FK_413EEE3EE3E32370 FOREIGN KEY (recouvre_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D988194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvres (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9E77B7C09 FOREIGN KEY (benevole_id) REFERENCES benevoles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artistes_oeuvres DROP FOREIGN KEY FK_1C7642ED96E1EAF4');
        $this->addSql('ALTER TABLE artistes_oeuvres DROP FOREIGN KEY FK_1C7642ED4928CE22');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3EA2C806AC');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3E1F8ACB26');
        $this->addSql('ALTER TABLE oeuvres DROP FOREIGN KEY FK_413EEE3EE3E32370');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D988194DE8');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9E77B7C09');
        $this->addSql('DROP TABLE artistes');
        $this->addSql('DROP TABLE artistes_oeuvres');
        $this->addSql('DROP TABLE benevoles');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE oeuvres');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE techniques');
    }
}
