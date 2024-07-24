<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724101444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, event_name VARCHAR(255) NOT NULL, event_date VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fraction (id INT AUTO_INCREMENT NOT NULL, fraction_name VARCHAR(255) NOT NULL, fraction_description VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL, date_modified DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scanned_object (id INT AUTO_INCREMENT NOT NULL, shper_id_id INT NOT NULL, event_id_id INT DEFAULT NULL, item_possession_id_id INT NOT NULL, photo_path VARCHAR(255) NOT NULL, pdf_path VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, general_description VARCHAR(255) DEFAULT NULL, background_description LONGTEXT DEFAULT NULL, analysis_result LONGTEXT DEFAULT NULL, who_brought_object_name_id VARCHAR(255) DEFAULT NULL, INDEX IDX_45009E89996BEFA (shper_id_id), INDEX IDX_45009E83E5F2F7B (event_id_id), INDEX IDX_45009E8204A8BB0 (item_possession_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shperacze (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, shper_number INT DEFAULT NULL, date_created DATETIME NOT NULL, date_modified DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scanned_object ADD CONSTRAINT FK_45009E89996BEFA FOREIGN KEY (shper_id_id) REFERENCES shperacze (id)');
        $this->addSql('ALTER TABLE scanned_object ADD CONSTRAINT FK_45009E83E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE scanned_object ADD CONSTRAINT FK_45009E8204A8BB0 FOREIGN KEY (item_possession_id_id) REFERENCES fraction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scanned_object DROP FOREIGN KEY FK_45009E89996BEFA');
        $this->addSql('ALTER TABLE scanned_object DROP FOREIGN KEY FK_45009E83E5F2F7B');
        $this->addSql('ALTER TABLE scanned_object DROP FOREIGN KEY FK_45009E8204A8BB0');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE fraction');
        $this->addSql('DROP TABLE scanned_object');
        $this->addSql('DROP TABLE shperacze');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
