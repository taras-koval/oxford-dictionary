<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026133802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_words (
    id INT AUTO_INCREMENT NOT NULL,
    word_id INT NOT NULL,
    user_id INT NOT NULL,
    INDEX IDX_2DF76C2EE357438D (word_id),
    INDEX IDX_2DF76C2EA76ED395 (user_id),
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_words ADD CONSTRAINT FK_2DF76C2EE357438D FOREIGN KEY (word_id) REFERENCES searches (id)');
        $this->addSql('ALTER TABLE favorite_words ADD CONSTRAINT FK_2DF76C2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_words DROP FOREIGN KEY FK_2DF76C2EE357438D');
        $this->addSql('ALTER TABLE favorite_words DROP FOREIGN KEY FK_2DF76C2EA76ED395');
        $this->addSql('DROP TABLE favorite_words');
    }
}
