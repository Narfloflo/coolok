<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104155020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flat (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, type VARCHAR(30) NOT NULL, furnished VARCHAR(30) NOT NULL, city VARCHAR(60) NOT NULL, surface INT NOT NULL, rooms INT NOT NULL, free_space INT NOT NULL, total_space INT NOT NULL, rent INT NOT NULL, description LONGTEXT NOT NULL, gender VARCHAR(30) NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_554AAA447E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(30) DEFAULT NULL, lastname VARCHAR(30) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', birthday DATE DEFAULT NULL, gender VARCHAR(30) DEFAULT NULL, city VARCHAR(60) DEFAULT NULL, description LONGTEXT DEFAULT NULL, passions LONGTEXT DEFAULT NULL, option_search VARCHAR(20) DEFAULT NULL, option_gender VARCHAR(20) NOT NULL, option_age_max INT DEFAULT NULL, option_age_min INT DEFAULT NULL, option_rent_min INT DEFAULT NULL, option_rent_max INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_flat (user_id INT NOT NULL, flat_id INT NOT NULL, INDEX IDX_2FCBE68DA76ED395 (user_id), INDEX IDX_2FCBE68DD3331C94 (flat_id), PRIMARY KEY(user_id, flat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE truc_bidule (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_25FDBD5A3AD8644E (user_source), INDEX IDX_25FDBD5A233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA447E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_flat ADD CONSTRAINT FK_2FCBE68DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_flat ADD CONSTRAINT FK_2FCBE68DD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE truc_bidule ADD CONSTRAINT FK_25FDBD5A3AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE truc_bidule ADD CONSTRAINT FK_25FDBD5A233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE TRUC_MACHIN');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_flat DROP FOREIGN KEY FK_2FCBE68DD3331C94');
        $this->addSql('ALTER TABLE flat DROP FOREIGN KEY FK_554AAA447E3C61F9');
        $this->addSql('ALTER TABLE user_flat DROP FOREIGN KEY FK_2FCBE68DA76ED395');
        $this->addSql('ALTER TABLE truc_bidule DROP FOREIGN KEY FK_25FDBD5A3AD8644E');
        $this->addSql('ALTER TABLE truc_bidule DROP FOREIGN KEY FK_25FDBD5A233D34C1');
        $this->addSql('CREATE TABLE TRUC_MACHIN (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_C5E9CA6D3AD8644E (user_source), INDEX IDX_C5E9CA6D233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE flat');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_flat');
        $this->addSql('DROP TABLE truc_bidule');
    }
}
