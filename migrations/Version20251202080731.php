<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251202080731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE profile_address_street profile_address_street VARCHAR(255) DEFAULT NULL, CHANGE profile_address_number profile_address_number VARCHAR(255) DEFAULT NULL, CHANGE profile_address_city profile_address_city VARCHAR(255) DEFAULT NULL, CHANGE profile_address_country profile_address_country VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE profile_address_street profile_address_street VARCHAR(255) NOT NULL, CHANGE profile_address_number profile_address_number VARCHAR(255) NOT NULL, CHANGE profile_address_city profile_address_city VARCHAR(255) NOT NULL, CHANGE profile_address_country profile_address_country VARCHAR(255) NOT NULL');
    }
}
