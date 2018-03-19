<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180319191945 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE weekend (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, endDate DATETIME NOT NULL, price NUMERIC(10, 0) NOT NULL, details LONGTEXT NOT NULL, banner VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exhibit (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, price NUMERIC(10, 0) NOT NULL, details LONGTEXT NOT NULL, banner VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_E4FBCD10989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, price NUMERIC(10, 0) NOT NULL, details LONGTEXT NOT NULL, banner VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(254) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, is_admin TINYINT(1) NOT NULL, exhibit TINYINT(1) NOT NULL, party TINYINT(1) NOT NULL, weekend TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_exhibit (user_id INT NOT NULL, exhibit_id INT NOT NULL, INDEX IDX_BCF6D31AA76ED395 (user_id), INDEX IDX_BCF6D31A2E5CE433 (exhibit_id), PRIMARY KEY(user_id, exhibit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_party (user_id INT NOT NULL, party_id INT NOT NULL, INDEX IDX_6B57B5B8A76ED395 (user_id), INDEX IDX_6B57B5B8213C1059 (party_id), PRIMARY KEY(user_id, party_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_weekend (user_id INT NOT NULL, weekend_id INT NOT NULL, INDEX IDX_F6DFD3A4A76ED395 (user_id), INDEX IDX_F6DFD3A4A32EAF0F (weekend_id), PRIMARY KEY(user_id, weekend_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_exhibit ADD CONSTRAINT FK_BCF6D31AA76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE user_exhibit ADD CONSTRAINT FK_BCF6D31A2E5CE433 FOREIGN KEY (exhibit_id) REFERENCES exhibit (id)');
        $this->addSql('ALTER TABLE user_party ADD CONSTRAINT FK_6B57B5B8A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE user_party ADD CONSTRAINT FK_6B57B5B8213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE user_weekend ADD CONSTRAINT FK_F6DFD3A4A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE user_weekend ADD CONSTRAINT FK_F6DFD3A4A32EAF0F FOREIGN KEY (weekend_id) REFERENCES weekend (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_weekend DROP FOREIGN KEY FK_F6DFD3A4A32EAF0F');
        $this->addSql('ALTER TABLE user_exhibit DROP FOREIGN KEY FK_BCF6D31A2E5CE433');
        $this->addSql('ALTER TABLE user_party DROP FOREIGN KEY FK_6B57B5B8213C1059');
        $this->addSql('ALTER TABLE user_exhibit DROP FOREIGN KEY FK_BCF6D31AA76ED395');
        $this->addSql('ALTER TABLE user_party DROP FOREIGN KEY FK_6B57B5B8A76ED395');
        $this->addSql('ALTER TABLE user_weekend DROP FOREIGN KEY FK_F6DFD3A4A76ED395');
        $this->addSql('DROP TABLE weekend');
        $this->addSql('DROP TABLE exhibit');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE user_exhibit');
        $this->addSql('DROP TABLE user_party');
        $this->addSql('DROP TABLE user_weekend');
    }
}
