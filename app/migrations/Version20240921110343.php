<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240921110343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elements ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elements ADD CONSTRAINT FK_444A075DF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_444A075DF675F31B ON elements (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elements DROP FOREIGN KEY FK_444A075DF675F31B');
        $this->addSql('DROP INDEX IDX_444A075DF675F31B ON elements');
        $this->addSql('ALTER TABLE elements DROP author_id');
    }
}
