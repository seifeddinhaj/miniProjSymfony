<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220144323 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonces ADD category_id INT DEFAULT NULL, ADD sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES subcategory (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F12469DE2 ON annonces (category_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FF7BFE87C ON annonces (sub_category_id)');
        $this->addSql('ALTER TABLE categories ADD annonces_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346684C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_3AF346684C2885D7 ON categories (annonces_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F12469DE2');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FF7BFE87C');
        $this->addSql('DROP INDEX IDX_CB988C6F12469DE2 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FF7BFE87C ON annonces');
        $this->addSql('ALTER TABLE annonces DROP category_id, DROP sub_category_id');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346684C2885D7');
        $this->addSql('DROP INDEX IDX_3AF346684C2885D7 ON categories');
        $this->addSql('ALTER TABLE categories DROP annonces_id');
    }
}
