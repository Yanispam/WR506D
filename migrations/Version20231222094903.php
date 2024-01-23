<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231222094903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor ADD media_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT FK_447556F964DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_447556F964DE5A5 ON actor (media_object_id)');
        $this->addSql('ALTER TABLE category ADD media_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C164DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_64C19C164DE5A5 ON category (media_object_id)');
        $this->addSql('ALTER TABLE movie ADD media_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F64DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F64DE5A5 ON movie (media_object_id)');
        $this->addSql('ALTER TABLE user ADD media_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64964DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64964DE5A5 ON user (media_object_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor DROP FOREIGN KEY FK_447556F964DE5A5');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C164DE5A5');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F64DE5A5');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64964DE5A5');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP INDEX IDX_447556F964DE5A5 ON actor');
        $this->addSql('ALTER TABLE actor DROP media_object_id');
        $this->addSql('DROP INDEX IDX_64C19C164DE5A5 ON category');
        $this->addSql('ALTER TABLE category DROP media_object_id');
        $this->addSql('DROP INDEX IDX_1D5EF26F64DE5A5 ON movie');
        $this->addSql('ALTER TABLE movie DROP media_object_id');
        $this->addSql('DROP INDEX IDX_8D93D64964DE5A5 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP media_object_id');
    }
}
