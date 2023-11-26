<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120141309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE documet (id INT AUTO_INCREMENT NOT NULL, ekdi1_id INT DEFAULT NULL, ekdi2_id INT DEFAULT NULL, ekdi3_id INT DEFAULT NULL, ekdi4_id INT DEFAULT NULL, fond VARCHAR(255) DEFAULT NULL, opis VARCHAR(255) NOT NULL, number_case VARCHAR(255) NOT NULL, number_list VARCHAR(255) NOT NULL, name LONGTEXT NOT NULL, anatation LONGTEXT NOT NULL, geography VARCHAR(255) NOT NULL, name_file VARCHAR(255) NOT NULL, INDEX IDX_96A92580A248B23F (ekdi1_id), INDEX IDX_96A92580B0FD1DD1 (ekdi2_id), INDEX IDX_96A925808417AB4 (ekdi3_id), INDEX IDX_96A925809596420D (ekdi4_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ekdi (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documet ADD CONSTRAINT FK_96A92580A248B23F FOREIGN KEY (ekdi1_id) REFERENCES ekdi (id)');
        $this->addSql('ALTER TABLE documet ADD CONSTRAINT FK_96A92580B0FD1DD1 FOREIGN KEY (ekdi2_id) REFERENCES ekdi (id)');
        $this->addSql('ALTER TABLE documet ADD CONSTRAINT FK_96A925808417AB4 FOREIGN KEY (ekdi3_id) REFERENCES ekdi (id)');
        $this->addSql('ALTER TABLE documet ADD CONSTRAINT FK_96A925809596420D FOREIGN KEY (ekdi4_id) REFERENCES ekdi (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documet DROP FOREIGN KEY FK_96A92580A248B23F');
        $this->addSql('ALTER TABLE documet DROP FOREIGN KEY FK_96A92580B0FD1DD1');
        $this->addSql('ALTER TABLE documet DROP FOREIGN KEY FK_96A925808417AB4');
        $this->addSql('ALTER TABLE documet DROP FOREIGN KEY FK_96A925809596420D');
        $this->addSql('DROP TABLE documet');
        $this->addSql('DROP TABLE ekdi');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
