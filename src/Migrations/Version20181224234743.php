<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181224234743 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346684C2885D7');
        $this->addSql('DROP INDEX IDX_3AF346684C2885D7 ON categories');
        $this->addSql('ALTER TABLE categories DROP annonces_id');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories ADD annonces_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346684C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_3AF346684C2885D7 ON categories (annonces_id)');
        $this->addSql('ALTER TABLE user DROP avatar');
    }
}
