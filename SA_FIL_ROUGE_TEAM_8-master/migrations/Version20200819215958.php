<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819215958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant (id INT NOT NULL, profil_sortie_id INT DEFAULT NULL, is_connected TINYINT(1) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, INDEX IDX_C4EB462E6409EF73 (profil_sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, formateur_id INT DEFAULT NULL, referentiel_id INT DEFAULT NULL, langue VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, contexte VARCHAR(255) DEFAULT NULL, livrable_attendus VARCHAR(255) DEFAULT NULL, modalites_pedagogiques VARCHAR(255) DEFAULT NULL, critere_de_performance VARCHAR(255) DEFAULT NULL, modalites_evaluation VARCHAR(255) DEFAULT NULL, avatar LONGBLOB DEFAULT NULL, date_creation DATETIME DEFAULT NULL, statut_brief VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_1FBB1007155D8F51 (formateur_id), INDEX IDX_1FBB1007805DB139 (referentiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_groupe (brief_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_5496297B757FABFF (brief_id), INDEX IDX_5496297B7A45358C (groupe_id), PRIMARY KEY(brief_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_tag (brief_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_452A4F36757FABFF (brief_id), INDEX IDX_452A4F36BAD26311 (tag_id), PRIMARY KEY(brief_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_general (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fil_de_discussion_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, piece_jointe LONGBLOB DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_BDE1A419A76ED395 (user_id), INDEX IDX_BDE1A4199E665F32 (fil_de_discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, livrable_rendu_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, piece_jointe LONGBLOB DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_D9BEC0C49F3E86A9 (livrable_rendu_id), INDEX IDX_D9BEC0C4155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fil_de_discussion (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_399E12C5D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promo_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_4B98C21D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_formateur (groupe_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_BDE2AD787A45358C (groupe_id), INDEX IDX_BDE2AD78155D8F51 (formateur_id), PRIMARY KEY(groupe_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_apprenant (groupe_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_947F95197A45358C (groupe_id), INDEX IDX_947F9519C5697D6D (apprenant_id), PRIMARY KEY(groupe_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, descriptif VARCHAR(255) DEFAULT NULL, INDEX IDX_54FD0400642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_competence (groupe_competences_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_48A1E18CC1218EC1 (groupe_competences_id), INDEX IDX_48A1E18C15761DAB (competence_id), PRIMARY KEY(groupe_competences_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_referentiel (groupe_competences_id INT NOT NULL, referentiel_id INT NOT NULL, INDEX IDX_9304F606C1218EC1 (groupe_competences_id), INDEX IDX_9304F606805DB139 (referentiel_id), PRIMARY KEY(groupe_competences_id, referentiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag_tag (groupe_tag_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C430CACFD1EC9F2B (groupe_tag_id), INDEX IDX_C430CACFBAD26311 (tag_id), PRIMARY KEY(groupe_tag_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_rendu (id INT AUTO_INCREMENT NOT NULL, livrables_partiels_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, delai DATETIME DEFAULT NULL, date_de_rendu DATETIME DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_9033AB0F2BE153F2 (livrables_partiels_id), INDEX IDX_9033AB0FC5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_FF9E7800C5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_attendus (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_attendus_brief (livrables_attendus_id INT NOT NULL, brief_id INT NOT NULL, INDEX IDX_B2E6638E251E52B2 (livrables_attendus_id), INDEX IDX_B2E6638E757FABFF (brief_id), PRIMARY KEY(livrables_attendus_id, brief_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_partiels (id INT AUTO_INCREMENT NOT NULL, promo_brief_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, delai DATETIME DEFAULT NULL, date_creation DATETIME DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_AC3B3FEABDA08EC7 (promo_brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_partiels_niveau (livrables_partiels_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_315C77E32BE153F2 (livrables_partiels_id), INDEX IDX_315C77E3B3E9C81 (niveau_id), PRIMARY KEY(livrables_partiels_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, groupe_action_arealiser LONGTEXT DEFAULT NULL, critere_evaluation LONGTEXT DEFAULT NULL, INDEX IDX_4BDFF36B757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_competence (niveau_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_C058EEB2B3E9C81 (niveau_id), INDEX IDX_C058EEB215761DAB (competence_id), PRIMARY KEY(niveau_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT NOT NULL, user_id INT NOT NULL, langue VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin_provisoire DATE DEFAULT NULL, fabrique VARCHAR(255) DEFAULT NULL, date_fin_reelle DATE DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_B0139AFB805DB139 (referentiel_id), INDEX IDX_B0139AFBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_formateur (promo_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_C5BC19F4D0C07AFF (promo_id), INDEX IDX_C5BC19F4155D8F51 (formateur_id), PRIMARY KEY(promo_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_brief (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_F6922C91D0C07AFF (promo_id), INDEX IDX_F6922C91757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_brief_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, promobrief_id INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_A9D0C93CC5697D6D (apprenant_id), INDEX IDX_A9D0C93C943F2B0 (promobrief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, presentation VARCHAR(255) DEFAULT NULL, programme LONGBLOB DEFAULT NULL, critere_admission VARCHAR(255) DEFAULT NULL, critere_evaluation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, piece_jointe LONGBLOB DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, INDEX IDX_939F4544757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistiques_competences (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, niveau1 TINYINT(1) DEFAULT NULL, niveau2 TINYINT(1) DEFAULT NULL, niveau3 TINYINT(1) DEFAULT NULL, INDEX IDX_5C1C9F22805DB139 (referentiel_id), INDEX IDX_5C1C9F2215761DAB (competence_id), INDEX IDX_5C1C9F22D0C07AFF (promo_id), INDEX IDX_5C1C9F22C5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, descriptif VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, genre VARCHAR(70) DEFAULT NULL, login VARCHAR(255) DEFAULT NULL, avatar LONGBLOB DEFAULT NULL, status VARCHAR(70) DEFAULT NULL, archivage TINYINT(1) DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462E6409EF73 FOREIGN KEY (profil_sortie_id) REFERENCES profil_sortie (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_tag ADD CONSTRAINT FK_452A4F36757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_tag ADD CONSTRAINT FK_452A4F36BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cm ADD CONSTRAINT FK_3C0A377EBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire_general ADD CONSTRAINT FK_BDE1A419A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire_general ADD CONSTRAINT FK_BDE1A4199E665F32 FOREIGN KEY (fil_de_discussion_id) REFERENCES fil_de_discussion (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C49F3E86A9 FOREIGN KEY (livrable_rendu_id) REFERENCES livrable_rendu (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE fil_de_discussion ADD CONSTRAINT FK_399E12C5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD787A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_formateur ADD CONSTRAINT FK_BDE2AD78155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F95197A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant ADD CONSTRAINT FK_947F9519C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences ADD CONSTRAINT FK_54FD0400642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE groupe_competences_competence ADD CONSTRAINT FK_48A1E18CC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_competence ADD CONSTRAINT FK_48A1E18C15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referentiel ADD CONSTRAINT FK_9304F606C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referentiel ADD CONSTRAINT FK_9304F606805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_rendu ADD CONSTRAINT FK_9033AB0F2BE153F2 FOREIGN KEY (livrables_partiels_id) REFERENCES livrables_partiels (id)');
        $this->addSql('ALTER TABLE livrable_rendu ADD CONSTRAINT FK_9033AB0FC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrables ADD CONSTRAINT FK_FF9E7800C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrables_attendus_brief ADD CONSTRAINT FK_B2E6638E251E52B2 FOREIGN KEY (livrables_attendus_id) REFERENCES livrables_attendus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_attendus_brief ADD CONSTRAINT FK_B2E6638E757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_partiels ADD CONSTRAINT FK_AC3B3FEABDA08EC7 FOREIGN KEY (promo_brief_id) REFERENCES promo_brief (id)');
        $this->addSql('ALTER TABLE livrables_partiels_niveau ADD CONSTRAINT FK_315C77E32BE153F2 FOREIGN KEY (livrables_partiels_id) REFERENCES livrables_partiels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_partiels_niveau ADD CONSTRAINT FK_315C77E3B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB2B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE promo_brief_apprenant ADD CONSTRAINT FK_A9D0C93CC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE promo_brief_apprenant ADD CONSTRAINT FK_A9D0C93C943F2B0 FOREIGN KEY (promobrief_id) REFERENCES promo_brief (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F2215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_competences DROP FOREIGN KEY FK_54FD0400642B8210');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F9519C5697D6D');
        $this->addSql('ALTER TABLE livrable_rendu DROP FOREIGN KEY FK_9033AB0FC5697D6D');
        $this->addSql('ALTER TABLE livrables DROP FOREIGN KEY FK_FF9E7800C5697D6D');
        $this->addSql('ALTER TABLE promo_brief_apprenant DROP FOREIGN KEY FK_A9D0C93CC5697D6D');
        $this->addSql('ALTER TABLE statistiques_competences DROP FOREIGN KEY FK_5C1C9F22C5697D6D');
        $this->addSql('ALTER TABLE brief_groupe DROP FOREIGN KEY FK_5496297B757FABFF');
        $this->addSql('ALTER TABLE brief_tag DROP FOREIGN KEY FK_452A4F36757FABFF');
        $this->addSql('ALTER TABLE livrables_attendus_brief DROP FOREIGN KEY FK_B2E6638E757FABFF');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B757FABFF');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91757FABFF');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544757FABFF');
        $this->addSql('ALTER TABLE groupe_competences_competence DROP FOREIGN KEY FK_48A1E18C15761DAB');
        $this->addSql('ALTER TABLE niveau_competence DROP FOREIGN KEY FK_C058EEB215761DAB');
        $this->addSql('ALTER TABLE statistiques_competences DROP FOREIGN KEY FK_5C1C9F2215761DAB');
        $this->addSql('ALTER TABLE commentaire_general DROP FOREIGN KEY FK_BDE1A4199E665F32');
        $this->addSql('ALTER TABLE brief DROP FOREIGN KEY FK_1FBB1007155D8F51');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4155D8F51');
        $this->addSql('ALTER TABLE groupe_formateur DROP FOREIGN KEY FK_BDE2AD78155D8F51');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE brief_groupe DROP FOREIGN KEY FK_5496297B7A45358C');
        $this->addSql('ALTER TABLE groupe_formateur DROP FOREIGN KEY FK_BDE2AD787A45358C');
        $this->addSql('ALTER TABLE groupe_apprenant DROP FOREIGN KEY FK_947F95197A45358C');
        $this->addSql('ALTER TABLE groupe_competences_competence DROP FOREIGN KEY FK_48A1E18CC1218EC1');
        $this->addSql('ALTER TABLE groupe_competences_referentiel DROP FOREIGN KEY FK_9304F606C1218EC1');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFD1EC9F2B');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C49F3E86A9');
        $this->addSql('ALTER TABLE livrables_attendus_brief DROP FOREIGN KEY FK_B2E6638E251E52B2');
        $this->addSql('ALTER TABLE livrable_rendu DROP FOREIGN KEY FK_9033AB0F2BE153F2');
        $this->addSql('ALTER TABLE livrables_partiels_niveau DROP FOREIGN KEY FK_315C77E32BE153F2');
        $this->addSql('ALTER TABLE livrables_partiels_niveau DROP FOREIGN KEY FK_315C77E3B3E9C81');
        $this->addSql('ALTER TABLE niveau_competence DROP FOREIGN KEY FK_C058EEB2B3E9C81');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462E6409EF73');
        $this->addSql('ALTER TABLE fil_de_discussion DROP FOREIGN KEY FK_399E12C5D0C07AFF');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21D0C07AFF');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4D0C07AFF');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91D0C07AFF');
        $this->addSql('ALTER TABLE statistiques_competences DROP FOREIGN KEY FK_5C1C9F22D0C07AFF');
        $this->addSql('ALTER TABLE livrables_partiels DROP FOREIGN KEY FK_AC3B3FEABDA08EC7');
        $this->addSql('ALTER TABLE promo_brief_apprenant DROP FOREIGN KEY FK_A9D0C93C943F2B0');
        $this->addSql('ALTER TABLE brief DROP FOREIGN KEY FK_1FBB1007805DB139');
        $this->addSql('ALTER TABLE groupe_competences_referentiel DROP FOREIGN KEY FK_9304F606805DB139');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB805DB139');
        $this->addSql('ALTER TABLE statistiques_competences DROP FOREIGN KEY FK_5C1C9F22805DB139');
        $this->addSql('ALTER TABLE brief_tag DROP FOREIGN KEY FK_452A4F36BAD26311');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFBAD26311');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EBF396750');
        $this->addSql('ALTER TABLE cm DROP FOREIGN KEY FK_3C0A377EBF396750');
        $this->addSql('ALTER TABLE commentaire_general DROP FOREIGN KEY FK_BDE1A419A76ED395');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FBF396750');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBA76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE brief_groupe');
        $this->addSql('DROP TABLE brief_tag');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE commentaire_general');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE fil_de_discussion');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_formateur');
        $this->addSql('DROP TABLE groupe_apprenant');
        $this->addSql('DROP TABLE groupe_competences');
        $this->addSql('DROP TABLE groupe_competences_competence');
        $this->addSql('DROP TABLE groupe_competences_referentiel');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE groupe_tag_tag');
        $this->addSql('DROP TABLE livrable_rendu');
        $this->addSql('DROP TABLE livrables');
        $this->addSql('DROP TABLE livrables_attendus');
        $this->addSql('DROP TABLE livrables_attendus_brief');
        $this->addSql('DROP TABLE livrables_partiels');
        $this->addSql('DROP TABLE livrables_partiels_niveau');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_competence');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_sortie');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_formateur');
        $this->addSql('DROP TABLE promo_brief');
        $this->addSql('DROP TABLE promo_brief_apprenant');
        $this->addSql('DROP TABLE referentiel');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE statistiques_competences');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
