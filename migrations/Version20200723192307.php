<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723192307 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liaison_tache_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tache_id INT NOT NULL, heure_prise DATETIME NOT NULL, INDEX IDX_A49D3626A76ED395 (user_id), UNIQUE INDEX UNIQ_A49D3626D2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liaison_tache_user ADD CONSTRAINT FK_A49D3626A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liaison_tache_user ADD CONSTRAINT FK_A49D3626D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE liaison_tache_user');
    }
}
