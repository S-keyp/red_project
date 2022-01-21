<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121160635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pro_bundles ADD service_category SMALLINT NOT NULL, CHANGE service_price service_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE prestation prestation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pro_bundles DROP service_category, CHANGE service_price service_price INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE prestation prestation INT NOT NULL');
    }
}
