<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223083249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BEC8B7ADE');
        $this->addSql('CREATE TABLE transaction_detail (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, category_id INT NOT NULL, group_member_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, month INT NOT NULL, year INT NOT NULL, INDEX IDX_587B0DD32FC0CB0F (transaction_id), INDEX IDX_587B0DD312469DE2 (category_id), INDEX IDX_587B0DD3B5248F1F (group_member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD32FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD3B5248F1F FOREIGN KEY (group_member_id) REFERENCES `member` (id)');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP INDEX IDX_73F2F77BEC8B7ADE ON budget');
        $this->addSql('ALTER TABLE budget ADD year INT NOT NULL, CHANGE period_id month INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, month INT NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD32FC0CB0F');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD312469DE2');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD3B5248F1F');
        $this->addSql('DROP TABLE transaction_detail');
        $this->addSql('ALTER TABLE budget ADD period_id INT NOT NULL, DROP month, DROP year');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77BEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_73F2F77BEC8B7ADE ON budget (period_id)');
    }
}
