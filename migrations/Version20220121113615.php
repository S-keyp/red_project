<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121113615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pro_bundles (id INT AUTO_INCREMENT NOT NULL, title_service VARCHAR(255) NOT NULL, description_service VARCHAR(255) NOT NULL, professionnal INT NOT NULL, image_service VARCHAR(255) DEFAULT NULL, service_price DOUBLE PRECISION NOT NULL, service_category SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, profile_picture VARCHAR(90) DEFAULT NULL, siret INT DEFAULT NULL, society_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, code_postal INT NOT NULL, email VARCHAR(90) NOT NULL, prestation INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pro_bundles');
        $this->addSql('DROP TABLE user');
    }
}
