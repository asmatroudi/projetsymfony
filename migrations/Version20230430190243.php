<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430190243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id_rec INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, Reclamation TEXT NOT NULL, Traitement TINYINT(1) NOT NULL, Sujet VARCHAR(255) NOT NULL, DateRec DATE NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE commentaire CHANGE id_event id_event INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('ALTER TABLE commentaire CHANGE id_event id_event INT DEFAULT NULL');
    }
}
