<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415025255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY fk_evenement_cat');
        $this->addSql('DROP INDEX name ON categorie');
        $this->addSql('DROP INDEX categorie_2 ON evenement');
        $this->addSql('DROP INDEX categorie ON evenement');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT fk_evenement_cat FOREIGN KEY (name) REFERENCES evenement (categorie) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX name ON categorie (name)');
        $this->addSql('CREATE INDEX categorie_2 ON evenement (categorie)');
        $this->addSql('CREATE INDEX categorie ON evenement (categorie)');
    }
}
