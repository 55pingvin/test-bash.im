<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827125310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complaint (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, created_by_id INT DEFAULT NULL, ghost_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F2732B54B89032C (post_id), INDEX IDX_5F2732B5B03A8386 (created_by_id), INDEX IDX_5F2732B53DD87830 (ghost_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ghost (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(15) NOT NULL, session VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, ghost_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5A8A6C8DB03A8386 (created_by_id), INDEX IDX_5A8A6C8D3DD87830 (ghost_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_rate (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, user_id INT DEFAULT NULL, ghost_id INT DEFAULT NULL, rate TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_16B958324B89032C (post_id), INDEX IDX_16B95832A76ED395 (user_id), INDEX IDX_16B958323DD87830 (ghost_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B54B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B53DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
        $this->addSql('ALTER TABLE post_rate ADD CONSTRAINT FK_16B958324B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_rate ADD CONSTRAINT FK_16B95832A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_rate ADD CONSTRAINT FK_16B958323DD87830 FOREIGN KEY (ghost_id) REFERENCES ghost (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B53DD87830');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D3DD87830');
        $this->addSql('ALTER TABLE post_rate DROP FOREIGN KEY FK_16B958323DD87830');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B54B89032C');
        $this->addSql('ALTER TABLE post_rate DROP FOREIGN KEY FK_16B958324B89032C');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B5B03A8386');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB03A8386');
        $this->addSql('ALTER TABLE post_rate DROP FOREIGN KEY FK_16B95832A76ED395');
        $this->addSql('DROP TABLE complaint');
        $this->addSql('DROP TABLE ghost');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_rate');
        $this->addSql('DROP TABLE user');
    }
}
