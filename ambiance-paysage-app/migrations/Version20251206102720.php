<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251206102720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE before_after_photo ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE photo ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE service ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE before_after_photo DROP updated_at');
        $this->addSql('ALTER TABLE photo DROP updated_at');
        $this->addSql('ALTER TABLE service DROP updated_at');
    }
}
