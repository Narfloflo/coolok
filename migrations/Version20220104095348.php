<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104095348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(30) NOT NULL, furnished VARCHAR(30) NOT NULL, owner TINYINT(1) NOT NULL, city VARCHAR(60) NOT NULL, surface INT NOT NULL, rooms INT NOT NULL, free_space INT NOT NULL, total_space INT NOT NULL, rent INT NOT NULL, description LONGTEXT NOT NULL, gender VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL, birthday DATE DEFAULT NULL, gender VARCHAR(30) NOT NULL, city VARCHAR(60) NOT NULL, description LONGTEXT NOT NULL, passions LONGTEXT NOT NULL, options_search VARCHAR(20) DEFAULT NULL, option_gender VARCHAR(20) DEFAULT NULL, option_age_min INT DEFAULT NULL, option_age_max INT DEFAULT NULL, option_rent_min INT DEFAULT NULL, option_rent_max INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE flat');
        $this->addSql('DROP TABLE `user`');
    }
}
