<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908150705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elements DROP FOREIGN KEY FK_444A075DF8697D13');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, element_id INT NOT NULL, email VARCHAR(64) NOT NULL, nick VARCHAR(64) NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_5F9E962A1F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A1F1F2A24 FOREIGN KEY (element_id) REFERENCES elements (id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1F1F2A24');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX IDX_444A075DF8697D13 ON elements');
        $this->addSql('ALTER TABLE elements DROP comment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, element_id INT NOT NULL, email VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nick VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_9474526C1F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1F1F2A24 FOREIGN KEY (element_id) REFERENCES elements (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A1F1F2A24');
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE elements ADD comment_id INT NOT NULL');
        $this->addSql('ALTER TABLE elements ADD CONSTRAINT FK_444A075DF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_444A075DF8697D13 ON elements (comment_id)');
    }
}
