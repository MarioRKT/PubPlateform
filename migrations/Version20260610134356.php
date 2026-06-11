<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260610134356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle ADD type_salle_id INT NOT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C11CF67C9 FOREIGN KEY (type_salle_id) REFERENCES type_salle (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5C11CF67C9 ON salle (type_salle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C11CF67C9');
        $this->addSql('DROP INDEX IDX_4E977E5C11CF67C9 ON salle');
        $this->addSql('ALTER TABLE salle DROP type_salle_id');
    }
}
