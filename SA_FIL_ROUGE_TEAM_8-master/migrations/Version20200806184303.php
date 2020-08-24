<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806184303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, groupe_action_arealiser LONGTEXT DEFAULT NULL, critere_evaluation LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_competence (niveau_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_C058EEB2B3E9C81 (niveau_id), INDEX IDX_C058EEB215761DAB (competence_id), PRIMARY KEY(niveau_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB2B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD78155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F9519C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE profil_id profil_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niveau_competence DROP FOREIGN KEY FK_C058EEB2B3E9C81');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_competence');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F9519C5697D6D');
        $this->addSql('ALTER TABLE groupe_formateur DROP FOREIGN KEY FK_BDE2AD78155D8F51');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE profil_id profil_id INT DEFAULT NULL');
    }
}
