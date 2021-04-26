<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421023911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_emp INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_enseignant (reunion_id INT NOT NULL, enseignant_id INT NOT NULL, INDEX IDX_659E16BC4E9B7368 (reunion_id), INDEX IDX_659E16BCE455FCC0 (enseignant_id), PRIMARY KEY(reunion_id, enseignant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reunion_enseignant ADD CONSTRAINT FK_659E16BC4E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_enseignant ADD CONSTRAINT FK_659E16BCE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reunion_enseignant DROP FOREIGN KEY FK_659E16BCE455FCC0');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE reunion_enseignant');
    }
}
