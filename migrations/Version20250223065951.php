<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223065951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_space (account_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_1FFD184B9B6B5FBA (account_id), INDEX IDX_1FFD184B23575340 (space_id), PRIMARY KEY(account_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_space (budget_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_426354CC36ABA6B8 (budget_id), INDEX IDX_426354CC23575340 (space_id), PRIMARY KEY(budget_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_space (category_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_C1418E7312469DE2 (category_id), INDEX IDX_C1418E7323575340 (space_id), PRIMARY KEY(category_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE counterparty_space (counterparty_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_A01D973CDB1FAD05 (counterparty_id), INDEX IDX_A01D973C23575340 (space_id), PRIMARY KEY(counterparty_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_space (member_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_4B5354C97597D3FE (member_id), INDEX IDX_4B5354C923575340 (space_id), PRIMARY KEY(member_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE space (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, professional TINYINT(1) NOT NULL, INDEX IDX_2972C13A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_space (transaction_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_8841117A2FC0CB0F (transaction_id), INDEX IDX_8841117A23575340 (space_id), PRIMARY KEY(transaction_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_space ADD CONSTRAINT FK_1FFD184B9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_space ADD CONSTRAINT FK_1FFD184B23575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_space ADD CONSTRAINT FK_426354CC36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_space ADD CONSTRAINT FK_426354CC23575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_space ADD CONSTRAINT FK_C1418E7312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_space ADD CONSTRAINT FK_C1418E7323575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE counterparty_space ADD CONSTRAINT FK_A01D973CDB1FAD05 FOREIGN KEY (counterparty_id) REFERENCES counterparty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE counterparty_space ADD CONSTRAINT FK_A01D973C23575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_space ADD CONSTRAINT FK_4B5354C97597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_space ADD CONSTRAINT FK_4B5354C923575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE space ADD CONSTRAINT FK_2972C13A727ACA70 FOREIGN KEY (parent_id) REFERENCES space (id)');
        $this->addSql('ALTER TABLE transaction_space ADD CONSTRAINT FK_8841117A2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_space ADD CONSTRAINT FK_8841117A23575340 FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_counterparty DROP FOREIGN KEY FK_DE5E32FC2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_counterparty DROP FOREIGN KEY FK_DE5E32FCDB1FAD05');
        $this->addSql('ALTER TABLE transaction_category DROP FOREIGN KEY FK_483E30A92FC0CB0F');
        $this->addSql('ALTER TABLE transaction_category DROP FOREIGN KEY FK_483E30A912469DE2');
        $this->addSql('DROP TABLE transaction_counterparty');
        $this->addSql('DROP TABLE transaction_category');
        $this->addSql('ALTER TABLE budget ADD period_id INT NOT NULL, DROP period_start, DROP period_end');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77BEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77BEC8B7ADE ON budget (period_id)');
        $this->addSql('ALTER TABLE category DROP type');
        $this->addSql('ALTER TABLE transaction ADD period_id INT NOT NULL, ADD counterparty_id INT NOT NULL, DROP date');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1DB1FAD05 FOREIGN KEY (counterparty_id) REFERENCES counterparty (id)');
        $this->addSql('CREATE INDEX IDX_723705D1EC8B7ADE ON transaction (period_id)');
        $this->addSql('CREATE INDEX IDX_723705D1DB1FAD05 ON transaction (counterparty_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_counterparty (transaction_id INT NOT NULL, counterparty_id INT NOT NULL, INDEX IDX_DE5E32FCDB1FAD05 (counterparty_id), INDEX IDX_DE5E32FC2FC0CB0F (transaction_id), PRIMARY KEY(transaction_id, counterparty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transaction_category (transaction_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_483E30A912469DE2 (category_id), INDEX IDX_483E30A92FC0CB0F (transaction_id), PRIMARY KEY(transaction_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction_counterparty ADD CONSTRAINT FK_DE5E32FC2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_counterparty ADD CONSTRAINT FK_DE5E32FCDB1FAD05 FOREIGN KEY (counterparty_id) REFERENCES counterparty (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_category ADD CONSTRAINT FK_483E30A92FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_category ADD CONSTRAINT FK_483E30A912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_space DROP FOREIGN KEY FK_1FFD184B9B6B5FBA');
        $this->addSql('ALTER TABLE account_space DROP FOREIGN KEY FK_1FFD184B23575340');
        $this->addSql('ALTER TABLE budget_space DROP FOREIGN KEY FK_426354CC36ABA6B8');
        $this->addSql('ALTER TABLE budget_space DROP FOREIGN KEY FK_426354CC23575340');
        $this->addSql('ALTER TABLE category_space DROP FOREIGN KEY FK_C1418E7312469DE2');
        $this->addSql('ALTER TABLE category_space DROP FOREIGN KEY FK_C1418E7323575340');
        $this->addSql('ALTER TABLE counterparty_space DROP FOREIGN KEY FK_A01D973CDB1FAD05');
        $this->addSql('ALTER TABLE counterparty_space DROP FOREIGN KEY FK_A01D973C23575340');
        $this->addSql('ALTER TABLE member_space DROP FOREIGN KEY FK_4B5354C97597D3FE');
        $this->addSql('ALTER TABLE member_space DROP FOREIGN KEY FK_4B5354C923575340');
        $this->addSql('ALTER TABLE space DROP FOREIGN KEY FK_2972C13A727ACA70');
        $this->addSql('ALTER TABLE transaction_space DROP FOREIGN KEY FK_8841117A2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_space DROP FOREIGN KEY FK_8841117A23575340');
        $this->addSql('DROP TABLE account_space');
        $this->addSql('DROP TABLE budget_space');
        $this->addSql('DROP TABLE category_space');
        $this->addSql('DROP TABLE counterparty_space');
        $this->addSql('DROP TABLE `member`');
        $this->addSql('DROP TABLE member_space');
        $this->addSql('DROP TABLE space');
        $this->addSql('DROP TABLE transaction_space');
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77BEC8B7ADE');
        $this->addSql('DROP INDEX IDX_73F2F77BEC8B7ADE ON budget');
        $this->addSql('ALTER TABLE budget ADD period_start DATE NOT NULL, ADD period_end DATE NOT NULL, DROP period_id');
        $this->addSql('ALTER TABLE category ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1EC8B7ADE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1DB1FAD05');
        $this->addSql('DROP INDEX IDX_723705D1EC8B7ADE ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1DB1FAD05 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD date DATE NOT NULL, DROP period_id, DROP counterparty_id');
    }
}
