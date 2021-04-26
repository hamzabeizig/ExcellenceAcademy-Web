<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421151705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant ADD departement_id INT NOT NULL, ADD user_name VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD date_naissance DATE NOT NULL, ADD role VARCHAR(255) NOT NULL, ADD mdp VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_81A72FA1CCF9E01E ON enseignant (departement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1CCF9E01E');
        $this->addSql('DROP INDEX IDX_81A72FA1CCF9E01E ON enseignant');
        $this->addSql('ALTER TABLE enseignant DROP departement_id, DROP user_name, DROP nom, DROP prenom, DROP email, DROP date_naissance, DROP role, DROP mdp');
    }
}
