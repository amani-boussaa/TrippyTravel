<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331142028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, id_category_id INT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', views INT NOT NULL, INDEX IDX_23A0E66A545015 (id_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articlimages (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_22A181277294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attraction (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT DEFAULT NULL, libelle VARCHAR(25) NOT NULL, localisation VARCHAR(30) DEFAULT NULL, horraire VARCHAR(30) DEFAULT NULL, prix INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_D503E6B89F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attraction_reservation (id INT AUTO_INCREMENT NOT NULL, attraction_id INT DEFAULT NULL, prix VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, start DATETIME DEFAULT CURRENT_TIMESTAMP, end DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_14B002203C216F9D (attraction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_attraction (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, contrainte_age TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, typechambre VARCHAR(255) NOT NULL, prix INT NOT NULL, description_chambre VARCHAR(255) NOT NULL, INDEX IDX_C509E4FF3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, annonces_id INT NOT NULL, parent_id INT DEFAULT NULL, content LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rgpd TINYINT(1) NOT NULL, INDEX IDX_5F9E962A4C2885D7 (annonces_id), INDEX IDX_5F9E962A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursion (id INT AUTO_INCREMENT NOT NULL, excursioncategorie_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, programme LONGTEXT NOT NULL, ville VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, duration VARCHAR(255) NOT NULL, localisation VARCHAR(255) DEFAULT NULL, INDEX IDX_9B08E72F83498997 (excursioncategorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursioncategorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursioncomment (id INT AUTO_INCREMENT NOT NULL, excursion_id INT DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, contenu LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, rgpd TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_FCF11D474AB4296F (excursion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursionimage (id INT AUTO_INCREMENT NOT NULL, excursion_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_51A2C7624AB4296F (excursion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excursionreservation (id INT AUTO_INCREMENT NOT NULL, excursion_id INT NOT NULL, user_id INT NOT NULL, prix VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, start DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, end DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, pi VARCHAR(255) DEFAULT NULL, INDEX IDX_4BA02EF34AB4296F (excursion_id), INDEX IDX_4BA02EF3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, nbetoile INT NOT NULL, nbchdispo INT NOT NULL, description_hotel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotelimage (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2FDDA2CC3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotelreservation (id INT AUTO_INCREMENT NOT NULL, chambre_id INT DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, cratedat DATETIME DEFAULT CURRENT_TIMESTAMP, start DATETIME DEFAULT CURRENT_TIMESTAMP, end DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_545753C09B177F54 (chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maison_reservation (id INT AUTO_INCREMENT NOT NULL, maisonshotes_id INT DEFAULT NULL, prix VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, createdat DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, start DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, end DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_3DDFB7C238B45370 (maisonshotes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maisonhoteimage (id INT AUTO_INCREMENT NOT NULL, maisonshotes_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_3F087E038B45370 (maisonshotes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maisonshotes (id INT AUTO_INCREMENT NOT NULL, type_maison_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, capacite INT NOT NULL, localisation VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, nbr_chambres INT NOT NULL, INDEX IDX_AF236C2A29A199BF (type_maison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, type_id INT NOT NULL, object VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, seen TINYINT(1) NOT NULL, INDEX IDX_CE60640419EB6921 (client_id), INDEX IDX_CE606404C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_maison (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, pub TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_rec (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, bio LONGTEXT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, naissance DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', sexe VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE articlimages ADD CONSTRAINT FK_22A181277294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE attraction ADD CONSTRAINT FK_D503E6B89F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie_attraction (id)');
        $this->addSql('ALTER TABLE attraction_reservation ADD CONSTRAINT FK_14B002203C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4C2885D7 FOREIGN KEY (annonces_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A727ACA70 FOREIGN KEY (parent_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE excursion ADD CONSTRAINT FK_9B08E72F83498997 FOREIGN KEY (excursioncategorie_id) REFERENCES excursioncategorie (id)');
        $this->addSql('ALTER TABLE excursioncomment ADD CONSTRAINT FK_FCF11D474AB4296F FOREIGN KEY (excursion_id) REFERENCES excursion (id)');
        $this->addSql('ALTER TABLE excursionimage ADD CONSTRAINT FK_51A2C7624AB4296F FOREIGN KEY (excursion_id) REFERENCES excursion (id)');
        $this->addSql('ALTER TABLE excursionreservation ADD CONSTRAINT FK_4BA02EF34AB4296F FOREIGN KEY (excursion_id) REFERENCES excursion (id)');
        $this->addSql('ALTER TABLE excursionreservation ADD CONSTRAINT FK_4BA02EF3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotelimage ADD CONSTRAINT FK_2FDDA2CC3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE hotelreservation ADD CONSTRAINT FK_545753C09B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE maison_reservation ADD CONSTRAINT FK_3DDFB7C238B45370 FOREIGN KEY (maisonshotes_id) REFERENCES maisonshotes (id)');
        $this->addSql('ALTER TABLE maisonhoteimage ADD CONSTRAINT FK_3F087E038B45370 FOREIGN KEY (maisonshotes_id) REFERENCES maisonshotes (id)');
        $this->addSql('ALTER TABLE maisonshotes ADD CONSTRAINT FK_AF236C2A29A199BF FOREIGN KEY (type_maison_id) REFERENCES type_maison (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640419EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C54C8C93 FOREIGN KEY (type_id) REFERENCES type_rec (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlimages DROP FOREIGN KEY FK_22A181277294869C');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4C2885D7');
        $this->addSql('ALTER TABLE attraction_reservation DROP FOREIGN KEY FK_14B002203C216F9D');
        $this->addSql('ALTER TABLE attraction DROP FOREIGN KEY FK_D503E6B89F34925F');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A545015');
        $this->addSql('ALTER TABLE hotelreservation DROP FOREIGN KEY FK_545753C09B177F54');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A727ACA70');
        $this->addSql('ALTER TABLE excursioncomment DROP FOREIGN KEY FK_FCF11D474AB4296F');
        $this->addSql('ALTER TABLE excursionimage DROP FOREIGN KEY FK_51A2C7624AB4296F');
        $this->addSql('ALTER TABLE excursionreservation DROP FOREIGN KEY FK_4BA02EF34AB4296F');
        $this->addSql('ALTER TABLE excursion DROP FOREIGN KEY FK_9B08E72F83498997');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF3243BB18');
        $this->addSql('ALTER TABLE hotelimage DROP FOREIGN KEY FK_2FDDA2CC3243BB18');
        $this->addSql('ALTER TABLE maison_reservation DROP FOREIGN KEY FK_3DDFB7C238B45370');
        $this->addSql('ALTER TABLE maisonhoteimage DROP FOREIGN KEY FK_3F087E038B45370');
        $this->addSql('ALTER TABLE maisonshotes DROP FOREIGN KEY FK_AF236C2A29A199BF');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C54C8C93');
        $this->addSql('ALTER TABLE excursionreservation DROP FOREIGN KEY FK_4BA02EF3A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640419EB6921');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE articlimages');
        $this->addSql('DROP TABLE attraction');
        $this->addSql('DROP TABLE attraction_reservation');
        $this->addSql('DROP TABLE categorie_attraction');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE excursion');
        $this->addSql('DROP TABLE excursioncategorie');
        $this->addSql('DROP TABLE excursioncomment');
        $this->addSql('DROP TABLE excursionimage');
        $this->addSql('DROP TABLE excursionreservation');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE hotelimage');
        $this->addSql('DROP TABLE hotelreservation');
        $this->addSql('DROP TABLE maison_reservation');
        $this->addSql('DROP TABLE maisonhoteimage');
        $this->addSql('DROP TABLE maisonshotes');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE type_maison');
        $this->addSql('DROP TABLE type_rec');
        $this->addSql('DROP TABLE user');
    }
}
