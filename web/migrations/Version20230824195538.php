<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230824195538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create History table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, temperature NUMERIC(4, 2) NOT NULL, cloudiness INT NOT NULL, wind NUMERIC(4, 2) NOT NULL, description VARCHAR(128) NOT NULL, lat NUMERIC(20, 16) NOT NULL, lng NUMERIC(20, 16) NOT NULL, city VARCHAR(128) NOT NULL, date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE history');
    }
}
