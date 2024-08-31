<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831152008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elements ADD comment_id INT NOT NULL');
        $this->addSql('ALTER TABLE elements ADD CONSTRAINT FK_444A075DF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_444A075DF8697D13 ON elements (comment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elements DROP FOREIGN KEY FK_444A075DF8697D13');
        $this->addSql('DROP INDEX IDX_444A075DF8697D13 ON elements');
        $this->addSql('ALTER TABLE elements DROP comment_id');
    }
}
