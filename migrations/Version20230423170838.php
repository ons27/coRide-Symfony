<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423170838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_trajet (id INT AUTO_INCREMENT NOT NULL, typet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet ADD type_trajet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CB9D4E933 FOREIGN KEY (type_trajet_id) REFERENCES type_trajet (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CB9D4E933 ON trajet (type_trajet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CB9D4E933');
        $this->addSql('DROP TABLE type_trajet');
        $this->addSql('DROP INDEX IDX_2B5BA98CB9D4E933 ON trajet');
        $this->addSql('ALTER TABLE trajet DROP type_trajet_id');
    }
}
