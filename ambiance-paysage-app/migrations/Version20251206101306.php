<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251206101306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE before_after_photo (id INT AUTO_INCREMENT NOT NULL, before_image VARCHAR(255) NOT NULL, after_image VARCHAR(255) NOT NULL, featured_on_homepage TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, day_name VARCHAR(255) NOT NULL, mode VARCHAR(255) NOT NULL, morning_start TIME DEFAULT NULL, morning_end TIME DEFAULT NULL, afternoon_start VARCHAR(255) DEFAULT NULL, afternoon_end VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prioritized TINYINT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE before_after_photo');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE social_network');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
