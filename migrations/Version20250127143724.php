<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127143724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE log_entries (id INT NOT NULL, service_name VARCHAR(55) NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, http_method VARCHAR(10) NOT NULL, endpoint VARCHAR(255) NOT NULL, status_code INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN log_entries.timestamp IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE log_entries');
    }
}
