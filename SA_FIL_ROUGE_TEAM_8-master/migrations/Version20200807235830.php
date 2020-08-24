<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807235830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo ADD user_id INT DEFAULT NULL, DROP reference_agate');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFBA76ED395 ON promo (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBA76ED395');
        $this->addSql('DROP INDEX IDX_B0139AFBA76ED395 ON promo');
        $this->addSql('ALTER TABLE promo ADD reference_agate VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP user_id');
    }
}
