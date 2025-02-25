<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225072713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, category_id INT NOT NULL, group_member_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, month INT NOT NULL, year INT NOT NULL, INDEX IDX_2E067F932FC0CB0F (transaction_id), INDEX IDX_2E067F9312469DE2 (category_id), INDEX IDX_2E067F93B5248F1F (group_member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F932FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93B5248F1F FOREIGN KEY (group_member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD3B5248F1F');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD32FC0CB0F');
        $this->addSql('ALTER TABLE transaction_detail DROP FOREIGN KEY FK_587B0DD312469DE2');
        $this->addSql('DROP TABLE transaction_detail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_detail (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, category_id INT NOT NULL, group_member_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, month INT NOT NULL, year INT NOT NULL, INDEX IDX_587B0DD32FC0CB0F (transaction_id), INDEX IDX_587B0DD312469DE2 (category_id), INDEX IDX_587B0DD3B5248F1F (group_member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD3B5248F1F FOREIGN KEY (group_member_id) REFERENCES `member` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD32FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE transaction_detail ADD CONSTRAINT FK_587B0DD312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F932FC0CB0F');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F9312469DE2');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93B5248F1F');
        $this->addSql('DROP TABLE detail');
    }
}
