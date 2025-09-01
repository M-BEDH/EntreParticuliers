<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250901105853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_provider ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_client ADD password VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user_login');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_provider DROP password');
        $this->addSql('ALTER TABLE user_client DROP password');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user_login (email)');
    }
}
