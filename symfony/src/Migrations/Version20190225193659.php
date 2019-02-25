<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190225193659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, post_type VARCHAR(20) NOT NULL, content_text LONGTEXT DEFAULT NULL, post_link VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5A8A6C8D989D9B62 (slug), INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_tag_post (post_tag_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_B685A9A8AF08774 (post_tag_id), INDEX IDX_B685A9A4B89032C (post_id), PRIMARY KEY(post_tag_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_653627B8A76ED395 (user_id), INDEX IDX_653627B84B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A99CE55FA76ED395 (user_id), INDEX IDX_A99CE55F4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE post_tag_post ADD CONSTRAINT FK_B685A9A8AF08774 FOREIGN KEY (post_tag_id) REFERENCES post_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_tag_post ADD CONSTRAINT FK_B685A9A4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_tag_post DROP FOREIGN KEY FK_B685A9A4B89032C');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F4B89032C');
        $this->addSql('ALTER TABLE post_tag_post DROP FOREIGN KEY FK_B685A9A8AF08774');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_tag');
        $this->addSql('DROP TABLE post_tag_post');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE post_comment');
    }
}
