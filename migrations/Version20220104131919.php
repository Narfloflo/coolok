<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104131919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE favorite_flat_flat');
        $this->addSql('DROP TABLE favorite_flat_user');
        $this->addSql('ALTER TABLE favorite_flat ADD user_id_id INT DEFAULT NULL, ADD flat_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorite_flat ADD CONSTRAINT FK_BB4CB37B9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favorite_flat ADD CONSTRAINT FK_BB4CB37BC5FCE984 FOREIGN KEY (flat_id_id) REFERENCES flat (id)');
        $this->addSql('CREATE INDEX IDX_BB4CB37B9D86650F ON favorite_flat (user_id_id)');
        $this->addSql('CREATE INDEX IDX_BB4CB37BC5FCE984 ON favorite_flat (flat_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_flat_flat (favorite_flat_id INT NOT NULL, flat_id INT NOT NULL, INDEX IDX_F71BE9228E67B2FA (favorite_flat_id), INDEX IDX_F71BE922D3331C94 (flat_id), PRIMARY KEY(favorite_flat_id, flat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE favorite_flat_user (favorite_flat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2FC2952F8E67B2FA (favorite_flat_id), INDEX IDX_2FC2952FA76ED395 (user_id), PRIMARY KEY(favorite_flat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favorite_flat_flat ADD CONSTRAINT FK_F71BE922D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_flat_flat ADD CONSTRAINT FK_F71BE9228E67B2FA FOREIGN KEY (favorite_flat_id) REFERENCES favorite_flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_flat_user ADD CONSTRAINT FK_2FC2952FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_flat_user ADD CONSTRAINT FK_2FC2952F8E67B2FA FOREIGN KEY (favorite_flat_id) REFERENCES favorite_flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_flat DROP FOREIGN KEY FK_BB4CB37B9D86650F');
        $this->addSql('ALTER TABLE favorite_flat DROP FOREIGN KEY FK_BB4CB37BC5FCE984');
        $this->addSql('DROP INDEX IDX_BB4CB37B9D86650F ON favorite_flat');
        $this->addSql('DROP INDEX IDX_BB4CB37BC5FCE984 ON favorite_flat');
        $this->addSql('ALTER TABLE favorite_flat DROP user_id_id, DROP flat_id_id');
    }
}
