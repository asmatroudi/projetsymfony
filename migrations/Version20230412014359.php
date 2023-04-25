<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412014359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activities DROP FOREIGN KEY activities_ibfk_1');
        $this->addSql('ALTER TABLE activity_likes DROP FOREIGN KEY activity_fk');
        $this->addSql('ALTER TABLE activity_likes DROP FOREIGN KEY user_fk');
        $this->addSql('ALTER TABLE articleculturel DROP FOREIGN KEY articleculturel_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_id_hotel');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY fk_id_event');
        $this->addSql('ALTER TABLE commentaire_likes DROP FOREIGN KEY FK_CC468661748C0F37');
        $this->addSql('ALTER TABLE commentaire_likes DROP FOREIGN KEY FK_CC468661A76ED395');
        $this->addSql('ALTER TABLE commentaire_reported DROP FOREIGN KEY FK_70139D7F6B3CA4B');
        $this->addSql('ALTER TABLE commentaire_reported DROP FOREIGN KEY FK_70139D7FFA122EBC');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY gouv_fk');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY auteur_fk');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY gouvernorat_fk');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274457C12B');
        $this->addSql('ALTER TABLE rate_evenement DROP FOREIGN KEY FK_AA202C706B3CA4B');
        $this->addSql('ALTER TABLE rate_hotel DROP FOREIGN KEY hotel_fk');
        $this->addSql('DROP TABLE activities');
        $this->addSql('DROP TABLE activity_likes');
        $this->addSql('DROP TABLE articleculturel');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE commentaire_likes');
        $this->addSql('DROP TABLE commentaire_reported');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE gouvernorat');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE rate_evenement');
        $this->addSql('DROP TABLE rate_hotel');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activities (id_activity INT AUTO_INCREMENT NOT NULL, gouvernorat INT DEFAULT NULL, description VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, num_contact VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, auteur INT DEFAULT NULL, type VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price INT NOT NULL, INDEX auteur (auteur), INDEX gouvernorat (gouvernorat), PRIMARY KEY(id_activity)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE activity_likes (id_like INT AUTO_INCREMENT NOT NULL, activity_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX user_fk (user_id), INDEX activity_fk (activity_id), PRIMARY KEY(id_like)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE articleculturel (id INT AUTO_INCREMENT NOT NULL, id_gouv INT DEFAULT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(5000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, temp_moyenne DOUBLE PRECISION NOT NULL, image VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX articleculturel_ibfk_1 (id_gouv), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (idcom INT AUTO_INCREMENT NOT NULL, id_hotel INT DEFAULT NULL, id_event INT DEFAULT NULL, contenue VARCHAR(7000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateajc DATE NOT NULL, auteur INT NOT NULL, INDEX fk_id_hotel (id_hotel), INDEX fk_id_event (id_event), PRIMARY KEY(idcom)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire_likes (id_like INT AUTO_INCREMENT NOT NULL, com_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX user_id (user_id), INDEX com_id (com_id), PRIMARY KEY(id_like)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire_reported (id_rep INT AUTO_INCREMENT NOT NULL, id_com INT DEFAULT NULL, id_user INT DEFAULT NULL, reason VARCHAR(7000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_com (id_com), INDEX FK_70139D7F6B3CA4B (id_user), PRIMARY KEY(id_rep)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (idev INT AUTO_INCREMENT NOT NULL, gouvernorat INT DEFAULT NULL, auteur INT DEFAULT NULL, region VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, datev DATE NOT NULL, titre VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price INT NOT NULL, INDEX gouv_fk (gouvernorat), INDEX auteur_fk (auteur), PRIMARY KEY(idev)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gouvernorat (id_gouver INT AUTO_INCREMENT NOT NULL, nom_gouver VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, region VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_gouver)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE hotel (idh INT AUTO_INCREMENT NOT NULL, gouvernorat INT DEFAULT NULL, nomhotel VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nb_etoile INT NOT NULL, site VARCHAR(7000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price INT NOT NULL, INDEX gouvernorat_fk (gouvernorat), PRIMARY KEY(idh)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plat (idplat INT AUTO_INCREMENT NOT NULL, nomplat VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, recette VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, chef VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, region VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idplat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (idp INT AUTO_INCREMENT NOT NULL, gouvernorat INT DEFAULT NULL, nomp VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price INT NOT NULL, INDEX IDX_29A5EC274457C12B (gouvernorat), PRIMARY KEY(idp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rate_evenement (id_rate INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_event INT NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, INDEX id_user (id_user), INDEX id_event (id_event), PRIMARY KEY(id_rate)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rate_hotel (id_rate INT AUTO_INCREMENT NOT NULL, id_hotel INT DEFAULT NULL, id_user INT NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, INDEX id_rate (id_rate), INDEX id_user (id_user), INDEX id_hotel (id_hotel), PRIMARY KEY(id_rate)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activities ADD CONSTRAINT activities_ibfk_1 FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE activity_likes ADD CONSTRAINT activity_fk FOREIGN KEY (activity_id) REFERENCES activities (id_activity)');
        $this->addSql('ALTER TABLE activity_likes ADD CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE articleculturel ADD CONSTRAINT articleculturel_ibfk_1 FOREIGN KEY (id_gouv) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_id_hotel FOREIGN KEY (id_hotel) REFERENCES hotel (idh) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT fk_id_event FOREIGN KEY (id_event) REFERENCES evenement (idev) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire_likes ADD CONSTRAINT FK_CC468661748C0F37 FOREIGN KEY (com_id) REFERENCES commentaire (idcom)');
        $this->addSql('ALTER TABLE commentaire_likes ADD CONSTRAINT FK_CC468661A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire_reported ADD CONSTRAINT FK_70139D7F6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire_reported ADD CONSTRAINT FK_70139D7FFA122EBC FOREIGN KEY (id_com) REFERENCES commentaire (idcom)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT gouv_fk FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT auteur_fk FOREIGN KEY (auteur) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT gouvernorat_fk FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE rate_evenement ADD CONSTRAINT FK_AA202C706B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate_hotel ADD CONSTRAINT hotel_fk FOREIGN KEY (id_hotel) REFERENCES hotel (idh)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user CHANGE id id INT NOT NULL, CHANGE email email VARCHAR(30) NOT NULL, CHANGE roles roles VARCHAR(30) NOT NULL, CHANGE password password VARCHAR(500) NOT NULL, CHANGE cin cin INT NOT NULL, CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenom prenom VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(30) NOT NULL');
    }
}
