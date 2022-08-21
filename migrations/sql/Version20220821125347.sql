CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE reset_password_request (id INT NOT NULL, user_id UUID NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id);
COMMENT ON COLUMN reset_password_request.user_id IS '(DC2Type:uuid)';
COMMENT ON COLUMN reset_password_request.requested_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN reset_password_request.expires_at IS '(DC2Type:datetime_immutable)';
ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user_sec (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
