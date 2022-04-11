<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220401152153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemons (id INT AUTO_INCREMENT NOT NULL, img VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, can_evolve INT NOT NULL, evolveid INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, gender INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainers_pokemons (trainers_id INT NOT NULL, pokemons_id INT NOT NULL, INDEX IDX_571E99B5B354E2E1 (trainers_id), INDEX IDX_571E99B5263F4792 (pokemons_id), PRIMARY KEY(trainers_id, pokemons_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trainers_pokemons ADD CONSTRAINT FK_571E99B5B354E2E1 FOREIGN KEY (trainers_id) REFERENCES trainers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainers_pokemons ADD CONSTRAINT FK_571E99B5263F4792 FOREIGN KEY (pokemons_id) REFERENCES pokemons (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainers_pokemons DROP FOREIGN KEY FK_571E99B5263F4792');
        $this->addSql('ALTER TABLE trainers_pokemons DROP FOREIGN KEY FK_571E99B5B354E2E1');
        $this->addSql('DROP TABLE pokemons');
        $this->addSql('DROP TABLE trainers');
        $this->addSql('DROP TABLE trainers_pokemons');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
