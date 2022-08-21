<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821133231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organization (id UUID NOT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT NULL, hashkey VARCHAR(12) DEFAULT NULL, identificador VARCHAR(100) NOT NULL, is_owner_site BOOLEAN DEFAULT NULL, tax_identification VARCHAR(255) DEFAULT NULL, legal_name VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, contact_phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1EE637CA8255881 ON organization (identificador)');
        $this->addSql('COMMENT ON COLUMN organization.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_sec ADD organization_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN user_sec.organization_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_sec ADD CONSTRAINT FK_8ED1C19032C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8ED1C19032C8A3DE ON user_sec (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_sec DROP CONSTRAINT FK_8ED1C19032C8A3DE');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP INDEX IDX_8ED1C19032C8A3DE');
        $this->addSql('ALTER TABLE user_sec DROP organization_id');
    }
}
