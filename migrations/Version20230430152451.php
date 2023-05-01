<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430152451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate_hotel (id_rate INT AUTO_INCREMENT NOT NULL, id_hotel INT DEFAULT NULL, id_user INT NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, INDEX id_hotel (id_hotel), INDEX id_rate (id_rate), INDEX id_user (id_user), PRIMARY KEY(id_rate)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nb_places INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_42C849553243BB18 (hotel_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_hotel ADD CONSTRAINT FK_931347FAEDD61FE9 FOREIGN KEY (id_hotel) REFERENCES hotel (idh)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849553243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (idh)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('DROP INDEX uniq_1d1c63b3e7927c74 ON utilisateur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B80EC64E7927C74 ON utilisateur (email)');
        $this->addSql('ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE555AB140 FOREIGN KEY (auteur) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE54457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE activity_likes ADD CONSTRAINT FK_57C878CEA76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE activity_likes ADD CONSTRAINT FK_57C878CE81C06096 FOREIGN KEY (activity_id) REFERENCES activities (id_activity)');
        $this->addSql('ALTER TABLE articleculturel ADD CONSTRAINT FK_38F2F558A430D903 FOREIGN KEY (id_gouv) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (idp)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE commentaire_likes ADD CONSTRAINT FK_CC468661748C0F37 FOREIGN KEY (com_id) REFERENCES commentaire (idcom)');
        $this->addSql('ALTER TABLE commentaire_likes ADD CONSTRAINT FK_CC468661A76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE commentaire_reported ADD CONSTRAINT FK_70139D7FFA122EBC FOREIGN KEY (id_com) REFERENCES commentaire (idcom)');
        $this->addSql('ALTER TABLE commentaire_reported ADD CONSTRAINT FK_70139D7F6B3CA4B FOREIGN KEY (id_user) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E55AB140 FOREIGN KEY (auteur) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E4457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED94457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE participation_activity ADD CONSTRAINT FK_405C85CD81C06096 FOREIGN KEY (activity_id) REFERENCES activities (id_activity)');
        $this->addSql('ALTER TABLE participation_activity ADD CONSTRAINT FK_405C85CDA76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE participation_event ADD CONSTRAINT FK_3472872C71F7E88B FOREIGN KEY (event_id) REFERENCES evenement (idev)');
        $this->addSql('ALTER TABLE participation_event ADD CONSTRAINT FK_3472872CA76ED395 FOREIGN KEY (user_id) REFERENCES Utilisateur (iduser)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2074457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274457C12B FOREIGN KEY (gouvernorat) REFERENCES gouvernorat (id_gouver)');
        $this->addSql('ALTER TABLE rate_evenement CHANGE id_user id_user VARCHAR(255) NOT NULL, CHANGE rate rate DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rate_hotel DROP FOREIGN KEY FK_931347FAEDD61FE9');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849553243BB18');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP TABLE rate_hotel');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE activities DROP FOREIGN KEY FK_B5F1AFE555AB140');
        $this->addSql('ALTER TABLE activities DROP FOREIGN KEY FK_B5F1AFE54457C12B');
        $this->addSql('ALTER TABLE activity_likes DROP FOREIGN KEY FK_57C878CEA76ED395');
        $this->addSql('ALTER TABLE activity_likes DROP FOREIGN KEY FK_57C878CE81C06096');
        $this->addSql('ALTER TABLE articleculturel DROP FOREIGN KEY FK_38F2F558A430D903');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commentaire_likes DROP FOREIGN KEY FK_CC468661748C0F37');
        $this->addSql('ALTER TABLE commentaire_likes DROP FOREIGN KEY FK_CC468661A76ED395');
        $this->addSql('ALTER TABLE commentaire_reported DROP FOREIGN KEY FK_70139D7FFA122EBC');
        $this->addSql('ALTER TABLE commentaire_reported DROP FOREIGN KEY FK_70139D7F6B3CA4B');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E55AB140');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E4457C12B');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED94457C12B');
        $this->addSql('ALTER TABLE participation_activity DROP FOREIGN KEY FK_405C85CD81C06096');
        $this->addSql('ALTER TABLE participation_activity DROP FOREIGN KEY FK_405C85CDA76ED395');
        $this->addSql('ALTER TABLE participation_event DROP FOREIGN KEY FK_3472872C71F7E88B');
        $this->addSql('ALTER TABLE participation_event DROP FOREIGN KEY FK_3472872CA76ED395');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2074457C12B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274457C12B');
        $this->addSql('ALTER TABLE rate_evenement CHANGE rate rate DOUBLE PRECISION NOT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_9b80ec64e7927c74 ON Utilisateur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON Utilisateur (email)');
    }
}
