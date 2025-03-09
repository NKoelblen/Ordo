<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308191619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget ADD recurrent TINYINT(1) DEFAULT 0 NOT NULL, ADD end_month INT DEFAULT NULL, ADD end_year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD recurrent TINYINT(1) DEFAULT 0 NOT NULL, ADD end_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP recurrent, DROP end_month, DROP end_year');
        $this->addSql('ALTER TABLE transaction DROP recurrent, DROP end_date');
    }
}
