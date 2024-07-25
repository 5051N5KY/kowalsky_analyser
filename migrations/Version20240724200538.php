<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724200538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `shperacze` (`id`, `nickname`, `shper_number`, `date_created`, `date_modified`, `active`) VALUES
            (1, 'Sosin', 248, '2024-07-24 20:07:13', NULL, 1),
            (2, 'Megamorda', 277, '2024-07-24 20:07:21', NULL, 1),
            (3, 'Radzu', 108, '2024-07-24 20:07:34', NULL, 1),
            (4, 'Kas', 270, '2024-07-24 20:07:41', NULL, 1);
            ");
        $this->addSql("INSERT INTO `fraction` (`id`, `fraction_name`, `fraction_description`, `date_created`, `date_modified`) VALUES
            (1, 'Shperacze', 'Shperactwo', '2024-07-24 20:09:20', NULL);");
        $this->addSql("INSERT INTO `event` (`id`, `event_name`, `event_date`, `date_created`, `date_modified`) VALUES
            (1, 'Trójdorado', '2024', '2024-07-24 20:09:29', NULL);");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
