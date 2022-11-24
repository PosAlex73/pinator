<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124181421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE diary_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE diary_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, status VARCHAR(1) NOT NULL, type VARCHAR(1) NOT NULL, published_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(1) NOT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE diary (id INT NOT NULL, dairy_user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_917BEDE241E8B33A ON diary (dairy_user_id)');
        $this->addSql('CREATE TABLE diary_post (id INT NOT NULL, diary_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41502D26E020E47A ON diary_post (diary_id)');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, status VARCHAR(16) NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, stop_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, type VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB2512469DE2 ON task (category_id)');
        $this->addSql('CREATE TABLE thread (id INT NOT NULL, tuser_id INT DEFAULT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31204C83773A4CE8 ON thread (tuser_id)');
        $this->addSql('CREATE TABLE thread_message (id INT NOT NULL, thread_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, created_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_707D836E2904019 ON thread_message (thread_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, for_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, about TEXT NOT NULL, target TEXT NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB4059B5BB4B8 ON user_profile (for_user_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE diary ADD CONSTRAINT FK_917BEDE241E8B33A FOREIGN KEY (dairy_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE diary_post ADD CONSTRAINT FK_41502D26E020E47A FOREIGN KEY (diary_id) REFERENCES diary (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83773A4CE8 FOREIGN KEY (tuser_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_message ADD CONSTRAINT FK_707D836E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4059B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE diary_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE diary_post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('ALTER TABLE diary DROP CONSTRAINT FK_917BEDE241E8B33A');
        $this->addSql('ALTER TABLE diary_post DROP CONSTRAINT FK_41502D26E020E47A');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB2512469DE2');
        $this->addSql('ALTER TABLE thread DROP CONSTRAINT FK_31204C83773A4CE8');
        $this->addSql('ALTER TABLE thread_message DROP CONSTRAINT FK_707D836E2904019');
        $this->addSql('ALTER TABLE user_profile DROP CONSTRAINT FK_D95AB4059B5BB4B8');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE diary');
        $this->addSql('DROP TABLE diary_post');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP TABLE thread_message');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
