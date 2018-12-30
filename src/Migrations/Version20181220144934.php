<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220144934 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE catalogue ADD annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F58805AB2F FOREIGN KEY (annonce_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_59A699F58805AB2F ON catalogue (annonce_id)');
        $this->addSql('ALTER TABLE subcategory ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_DDCA44812469DE2 ON subcategory (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F58805AB2F');
        $this->addSql('DROP INDEX IDX_59A699F58805AB2F ON catalogue');
        $this->addSql('ALTER TABLE catalogue DROP annonce_id');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('DROP INDEX IDX_DDCA44812469DE2 ON subcategory');
        $this->addSql('ALTER TABLE subcategory DROP category_id');
    }
}
