<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122101126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documet CHANGE number_list number_list VARCHAR(255) DEFAULT NULL, CHANGE name name LONGTEXT DEFAULT NULL, CHANGE anatation anatation LONGTEXT DEFAULT NULL, CHANGE geography geography VARCHAR(255) DEFAULT NULL, CHANGE name_file name_file VARCHAR(255) DEFAULT NULL, CHANGE user_group user_group VARCHAR(255) DEFAULT NULL, CHANGE deadline_dates deadline_dates VARCHAR(255) DEFAULT NULL, CHANGE name_case name_case LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documet CHANGE number_list number_list VARCHAR(255) NOT NULL, CHANGE name name LONGTEXT NOT NULL, CHANGE anatation anatation LONGTEXT NOT NULL, CHANGE geography geography VARCHAR(255) NOT NULL, CHANGE name_file name_file VARCHAR(255) NOT NULL, CHANGE user_group user_group VARCHAR(255) NOT NULL, CHANGE deadline_dates deadline_dates VARCHAR(255) NOT NULL, CHANGE name_case name_case LONGTEXT NOT NULL');
    }
}
