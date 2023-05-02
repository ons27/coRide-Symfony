<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502224645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404EF672883');
        $this->addSql('DROP INDEX IDX_CE606404EF672883 ON reclamation');
        $this->addSql('ALTER TABLE reclamation CHANGE type_reclamations_id type_reclamation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047BA88B4D FOREIGN KEY (type_reclamation_id) REFERENCES type_reclamation (id)');
        $this->addSql('CREATE INDEX IDX_CE6064047BA88B4D ON reclamation (type_reclamation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047BA88B4D');
        $this->addSql('DROP INDEX IDX_CE6064047BA88B4D ON reclamation');
        $this->addSql('ALTER TABLE reclamation CHANGE type_reclamation_id type_reclamations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404EF672883 FOREIGN KEY (type_reclamations_id) REFERENCES type_reclamation (id)');
        $this->addSql('CREATE INDEX IDX_CE606404EF672883 ON reclamation (type_reclamations_id)');
    }
}
