<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828122731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B53DD87830');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D3DD87830');
        $this->addSql('ALTER TABLE post_rate DROP FOREIGN KEY FK_16B958323DD87830');
        $this->addSql('DROP TABLE ghost');
        $this->addSql('DROP INDEX IDX_5F2732B53DD87830 ON complaint');
        $this->addSql('ALTER TABLE complaint DROP ghost_id');
        $this->addSql('DROP INDEX IDX_5A8A6C8D3DD87830 ON post');
        $this->addSql('ALTER TABLE post ADD ipv4 VARCHAR(16) NOT NULL, DROP ghost_id');
        $this->addSql('DROP INDEX IDX_16B958323DD87830 ON post_rate');
        $this->addSql('ALTER TABLE post_rate ADD ipv4 VARCHAR(16) NOT NULL, DROP ghost_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ghost (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, session VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE complaint ADD ghost_id INT NOT NULL');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B53DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
        $this->addSql('CREATE INDEX IDX_5F2732B53DD87830 ON complaint (ghost_id)');
        $this->addSql('ALTER TABLE post ADD ghost_id INT DEFAULT NULL, DROP ipv4');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D3DD87830 ON post (ghost_id)');
        $this->addSql('ALTER TABLE post_rate ADD ghost_id INT DEFAULT NULL, DROP ipv4');
        $this->addSql('ALTER TABLE post_rate ADD CONSTRAINT FK_16B958323DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
        $this->addSql('CREATE INDEX IDX_16B958323DD87830 ON post_rate (ghost_id)');
    }
}
