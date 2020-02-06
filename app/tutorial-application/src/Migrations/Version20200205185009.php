<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205185009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        for ($x = 1; $x <= 1000; $x++) {
            $this->addSql(sprintf('INSERT INTO car (number_of_doors, license_plate) VALUES(4, "AA-AA-%d")', $x));
        }
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('TRUNCATE TABLE car');
    }
}
