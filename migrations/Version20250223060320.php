<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223060320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE counterparty (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_counterparty (transaction_id INT NOT NULL, counterparty_id INT NOT NULL, INDEX IDX_DE5E32FC2FC0CB0F (transaction_id), INDEX IDX_DE5E32FCDB1FAD05 (counterparty_id), PRIMARY KEY(transaction_id, counterparty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction_counterparty ADD CONSTRAINT FK_DE5E32FC2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_counterparty ADD CONSTRAINT FK_DE5E32FCDB1FAD05 FOREIGN KEY (counterparty_id) REFERENCES counterparty (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction_counterparty DROP FOREIGN KEY FK_DE5E32FC2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_counterparty DROP FOREIGN KEY FK_DE5E32FCDB1FAD05');
        $this->addSql('DROP TABLE counterparty');
        $this->addSql('DROP TABLE transaction_counterparty');
    }
}
