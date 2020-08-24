<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200803173033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_formateur');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F9519C5697D6D');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F9519C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe_competences ADD CONSTRAINT FK_54FD0400642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_54FD0400642B8210 ON groupe_competences (admin_id)');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_formateur (groupe_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_BDE2AD78155D8F51 (formateur_id), INDEX IDX_BDE2AD787A45358C (groupe_id), PRIMARY KEY(groupe_id, formateur_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD787A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F9519C5697D6D');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F9519C5697D6D FOREIGN KEY (apprenant_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences DROP FOREIGN KEY FK_54FD0400642B8210');
        $this->addSql('DROP INDEX IDX_54FD0400642B8210 ON groupe_competences');
        $this->addSql('ALTER TABLE groupe_competences DROP admin_id');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
