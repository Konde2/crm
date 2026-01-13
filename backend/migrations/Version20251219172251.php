<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251219172251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit_logs (id UUID NOT NULL, entity VARCHAR(50) NOT NULL, entity_id UUID NOT NULL, action VARCHAR(50) NOT NULL, old_value JSON DEFAULT NULL, new_value JSON DEFAULT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, changed_by_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_D62F2858828AD0A0 ON audit_logs (changed_by_id)');
        $this->addSql('CREATE TABLE comments (id UUID NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deal_id UUID NOT NULL, author_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_5F9E962AF60E2305 ON comments (deal_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AF675F31B ON comments (author_id)');
        $this->addSql('CREATE TABLE comment_mentions (comment_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY (comment_id, user_id))');
        $this->addSql('CREATE INDEX IDX_E37D1059F8697D13 ON comment_mentions (comment_id)');
        $this->addSql('CREATE INDEX IDX_E37D1059A76ED395 ON comment_mentions (user_id)');
        $this->addSql('CREATE TABLE deals (id UUID NOT NULL, title VARCHAR(255) NOT NULL, stage VARCHAR(20) NOT NULL, priority VARCHAR(20) NOT NULL, value NUMERIC(12, 2) DEFAULT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, company VARCHAR(100) DEFAULT NULL, notes TEXT DEFAULT NULL, tags JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, closed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, contact_name VARCHAR(255) NOT NULL, contact_phone VARCHAR(50) NOT NULL, contact_email VARCHAR(255) NOT NULL, created_by_id UUID NOT NULL, assigned_to_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_EF39849BB03A8386 ON deals (created_by_id)');
        $this->addSql('CREATE INDEX IDX_EF39849BF4BD7827 ON deals (assigned_to_id)');
        $this->addSql('CREATE TABLE files (id UUID NOT NULL, original_name VARCHAR(255) NOT NULL, mime_type VARCHAR(100) NOT NULL, size INT NOT NULL, storage_path VARCHAR(500) NOT NULL, uploaded_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uploaded_by_id UUID NOT NULL, deal_id UUID NOT NULL, comment_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_6354059A2B28FE8 ON files (uploaded_by_id)');
        $this->addSql('CREATE INDEX IDX_6354059F60E2305 ON files (deal_id)');
        $this->addSql('CREATE INDEX IDX_6354059F8697D13 ON files (comment_id)');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, oauth_provider VARCHAR(20) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_login_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE audit_logs ADD CONSTRAINT FK_D62F2858828AD0A0 FOREIGN KEY (changed_by_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF60E2305 FOREIGN KEY (deal_id) REFERENCES deals (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE comment_mentions ADD CONSTRAINT FK_E37D1059F8697D13 FOREIGN KEY (comment_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_mentions ADD CONSTRAINT FK_E37D1059A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849BB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE deals ADD CONSTRAINT FK_EF39849BF4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059F60E2305 FOREIGN KEY (deal_id) REFERENCES deals (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059F8697D13 FOREIGN KEY (comment_id) REFERENCES comments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit_logs DROP CONSTRAINT FK_D62F2858828AD0A0');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962AF60E2305');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE comment_mentions DROP CONSTRAINT FK_E37D1059F8697D13');
        $this->addSql('ALTER TABLE comment_mentions DROP CONSTRAINT FK_E37D1059A76ED395');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849BB03A8386');
        $this->addSql('ALTER TABLE deals DROP CONSTRAINT FK_EF39849BF4BD7827');
        $this->addSql('ALTER TABLE files DROP CONSTRAINT FK_6354059A2B28FE8');
        $this->addSql('ALTER TABLE files DROP CONSTRAINT FK_6354059F60E2305');
        $this->addSql('ALTER TABLE files DROP CONSTRAINT FK_6354059F8697D13');
        $this->addSql('DROP TABLE audit_logs');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE comment_mentions');
        $this->addSql('DROP TABLE deals');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE users');
    }
}
