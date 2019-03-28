<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190308093508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE friend_ship (id INT AUTO_INCREMENT NOT NULL, friend_id INT NOT NULL, friend_with_me_id INT NOT NULL, friend_ship_type VARCHAR(50) NOT NULL, accepted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_604A37C46A5458E8 (friend_id), INDEX IDX_604A37C43059BA49 (friend_with_me_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friend_ship ADD CONSTRAINT FK_604A37C46A5458E8 FOREIGN KEY (friend_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE friend_ship ADD CONSTRAINT FK_604A37C43059BA49 FOREIGN KEY (friend_with_me_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE friend_ship');
    }
}
