<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219102604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE migrations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE failed_jobs_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_access_tokens_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE car_models_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_models_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_to_car_models_id_seq CASCADE');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('DROP TABLE personal_access_tokens');
        $this->addSql('DROP TABLE user_models');
        $this->addSql('DROP TABLE car_models');
        $this->addSql('DROP TABLE password_reset_tokens');
        $this->addSql('DROP TABLE user_to_car_models');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE failed_jobs');
        $this->addSql('DROP TABLE migrations');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE migrations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE failed_jobs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_access_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE car_models_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_models_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_to_car_models_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal_access_tokens (id BIGSERIAL NOT NULL, tokenable_type VARCHAR(255) NOT NULL, tokenable_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, token VARCHAR(64) NOT NULL, abilities TEXT DEFAULT NULL, last_used_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX personal_access_tokens_token_unique ON personal_access_tokens (token)');
        $this->addSql('CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON personal_access_tokens (tokenable_type, tokenable_id)');
        $this->addSql('CREATE TABLE user_models (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, role INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE car_models (id BIGSERIAL NOT NULL, brand VARCHAR(255) NOT NULL, class INT NOT NULL, is_free BOOLEAN DEFAULT true NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE password_reset_tokens (email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(email))');
        $this->addSql('CREATE TABLE user_to_car_models (id BIGSERIAL NOT NULL, id_user INT NOT NULL, id_car INT NOT NULL, is_returned BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX users_email_unique ON users (email)');
        $this->addSql('CREATE TABLE failed_jobs (id BIGSERIAL NOT NULL, uuid VARCHAR(255) NOT NULL, connection TEXT NOT NULL, queue TEXT NOT NULL, payload TEXT NOT NULL, exception TEXT NOT NULL, failed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX failed_jobs_uuid_unique ON failed_jobs (uuid)');
        $this->addSql('CREATE TABLE migrations (id SERIAL NOT NULL, migration VARCHAR(255) NOT NULL, batch INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
