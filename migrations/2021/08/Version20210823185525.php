<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823185525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'post & user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD author_id INT NOT NULL, ADD remote_id INT DEFAULT NULL, ADD sync_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX author_id ON post (author_id)');
        $this->addSql('CREATE INDEX remote_id ON post (remote_id)');
        $this->addSql('CREATE UNIQUE INDEX slug ON post (slug)');
        $this->addSql('CREATE INDEX remote_id ON user (remote_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('DROP INDEX author_id ON post');
        $this->addSql('DROP INDEX remote_id ON post');
        $this->addSql('DROP INDEX slug ON post');
        $this->addSql('ALTER TABLE post DROP author_id, DROP remote_id, DROP sync_at');
        $this->addSql('DROP INDEX remote_id ON user');
    }
}
