CREATE TABLE organization (id UUID NOT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT NULL, hashkey VARCHAR(12) DEFAULT NULL, identificador VARCHAR(100) NOT NULL, is_owner_site BOOLEAN DEFAULT NULL, tax_identification VARCHAR(255) DEFAULT NULL, legal_name VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, contact_phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_C1EE637CA8255881 ON organization (identificador);
COMMENT ON COLUMN organization.id IS '(DC2Type:uuid)';
ALTER TABLE user_sec ADD organization_id UUID DEFAULT NULL;
COMMENT ON COLUMN user_sec.organization_id IS '(DC2Type:uuid)';
ALTER TABLE user_sec ADD CONSTRAINT FK_8ED1C19032C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE INDEX IDX_8ED1C19032C8A3DE ON user_sec (organization_id);
