<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223091451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget ADD group_member_id INT NOT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77BB5248F1F FOREIGN KEY (group_member_id) REFERENCES `member` (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77BB5248F1F ON budget (group_member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BB5248F1F');
        $this->addSql('DROP INDEX IDX_73F2F77BB5248F1F ON budget');
        $this->addSql('ALTER TABLE budget DROP group_member_id');
    }
}
