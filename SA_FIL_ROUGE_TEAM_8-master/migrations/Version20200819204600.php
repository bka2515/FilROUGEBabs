<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819204600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_brief_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, promobrief_id INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_A9D0C93CC5697D6D (apprenant_id), INDEX IDX_A9D0C93C943F2B0 (promobrief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistiques_competences (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, niveau1 TINYINT(1) DEFAULT NULL, niveau2 TINYINT(1) DEFAULT NULL, niveau3 TINYINT(1) DEFAULT NULL, INDEX IDX_5C1C9F22805DB139 (referentiel_id), INDEX IDX_5C1C9F2215761DAB (competence_id), INDEX IDX_5C1C9F22D0C07AFF (promo_id), INDEX IDX_5C1C9F22C5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_brief_apprenant ADD CONSTRAINT FK_A9D0C93CC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE promo_brief_apprenant ADD CONSTRAINT FK_A9D0C93C943F2B0 FOREIGN KEY (promobrief_id) REFERENCES promo_brief (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F2215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo_brief_apprenant');
        $this->addSql('DROP TABLE statistiques_competences');
    }
}
