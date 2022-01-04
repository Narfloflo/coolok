<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104155557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_flat (user_id INT NOT NULL, flat_id INT NOT NULL, INDEX IDX_BB4CB37BA76ED395 (user_id), INDEX IDX_BB4CB37BD3331C94 (flat_id), PRIMARY KEY(user_id, flat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_6395CF763AD8644E (user_source), INDEX IDX_6395CF76233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_flat ADD CONSTRAINT FK_BB4CB37BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_flat ADD CONSTRAINT FK_BB4CB37BD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_user ADD CONSTRAINT FK_6395CF763AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_user ADD CONSTRAINT FK_6395CF76233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE truc_bidule');
        $this->addSql('DROP TABLE user_flat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE truc_bidule (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_25FDBD5A3AD8644E (user_source), INDEX IDX_25FDBD5A233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_flat (user_id INT NOT NULL, flat_id INT NOT NULL, INDEX IDX_2FCBE68DD3331C94 (flat_id), INDEX IDX_2FCBE68DA76ED395 (user_id), PRIMARY KEY(user_id, flat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE truc_bidule ADD CONSTRAINT FK_25FDBD5A3AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE truc_bidule ADD CONSTRAINT FK_25FDBD5A233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_flat ADD CONSTRAINT FK_2FCBE68DD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_flat ADD CONSTRAINT FK_2FCBE68DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE favorite_flat');
        $this->addSql('DROP TABLE favorite_user');
    }
}
