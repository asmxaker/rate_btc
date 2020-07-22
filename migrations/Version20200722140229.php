<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722140229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rates (id INT AUTO_INCREMENT NOT NULL, currency_id_id INT NOT NULL, rate_value DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_44D4AB3C28A69C31 (currency_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rates ADD CONSTRAINT FK_44D4AB3C28A69C31 FOREIGN KEY (currency_id_id) REFERENCES currencies (id)');
        $this->addSql('DROP INDEX currencies_code ON currencies');
        $this->addSql('DROP INDEX currencies_id ON currencies');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rates');
        $this->addSql('CREATE UNIQUE INDEX currencies_code ON currencies (code)');
        $this->addSql('CREATE UNIQUE INDEX currencies_id ON currencies (id)');
    }
}
