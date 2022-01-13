<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113162325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matching (id INT AUTO_INCREMENT NOT NULL, user_a_id INT NOT NULL, user_b_id INT NOT NULL, matching_at DATETIME NOT NULL, INDEX IDX_DC10F289415F1F91 (user_a_id), INDEX IDX_DC10F28953EAB07F (user_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F289415F1F91 FOREIGN KEY (user_a_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F28953EAB07F FOREIGN KEY (user_b_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE matching');
    }
}
