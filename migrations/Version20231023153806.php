<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023153806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cook (id INT AUTO_INCREMENT NOT NULL, kitchen_id INT NOT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, INDEX IDX_7359C4545F858004 (kitchen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cook ADD CONSTRAINT FK_7359C4545F858004 FOREIGN KEY (kitchen_id) REFERENCES kitchen (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cook DROP FOREIGN KEY FK_7359C4545F858004');
        $this->addSql('DROP TABLE cook');
    }
}
