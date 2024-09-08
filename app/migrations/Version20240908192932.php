<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908192932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD element_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1F1F2A24 FOREIGN KEY (element_id) REFERENCES elements (id)');
        $this->addSql('CREATE INDEX IDX_9474526C1F1F2A24 ON comment (element_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1F1F2A24');
        $this->addSql('DROP INDEX IDX_9474526C1F1F2A24 ON comment');
        $this->addSql('ALTER TABLE comment DROP element_id');
    }
}
