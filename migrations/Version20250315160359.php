<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315160359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget_space DROP FOREIGN KEY FK_426354CC36ABA6B8');
        $this->addSql('ALTER TABLE budget_space DROP FOREIGN KEY FK_426354CC23575340');
        $this->addSql('DROP TABLE budget_space');
        $this->addSql('ALTER TABLE budget ADD space_id INT NOT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B23575340 FOREIGN KEY (space_id) REFERENCES space (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77B23575340 ON budget (space_id)');
        $this->addSql('ALTER TABLE space DROP accounting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget_space (budget_id INT NOT NULL, space_id INT NOT NULL, INDEX IDX_426354CC36ABA6B8 (budget_id), INDEX IDX_426354CC23575340 (space_id), PRIMARY KEY(budget_id, space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE budget_space ADD CONSTRAINT FK_426354CC36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_space ADD CONSTRAINT FK_426354CC23575340 FOREIGN KEY (space_id) REFERENCES space (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B23575340');
        $this->addSql('DROP INDEX IDX_73F2F77B23575340 ON budget');
        $this->addSql('ALTER TABLE budget DROP space_id');
        $this->addSql('ALTER TABLE space ADD accounting TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
