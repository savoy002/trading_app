<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version2025102014234 extends AbstractMigration
{
	public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
    	$this->addSql('CREATE TABLE ENTREPRISE (id_ent INT AUTO_INCREMENT NOT NULL, nom_ent VARCHAR(255), sym_ent VARCHAR(10), inf_ent TEXT, PRIMARY KEY(id_ent)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    	$this->addSql('CREATE TABLE DATE_INFO (id_date INT AUTO_INCREMENT NOT NULL, val_date DATE, type_date VARCHAR(1), PRIMARY KEY(id_date)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    	$this->addSql('CREATE TABLE VALEUR (id_val INT AUTO_INCREMENT NOT NULL, id_ent INT NOT NULL, id_date INT NOT NULL, ouv_val INT, hau_val INT, bas_val INT, fer_val INT, vol_val INT, PRIMARY KEY (id_val), INDEX (id_ent), INDEX (id_date)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    	$this->addSql('ALTER TABLE VALEUR Add CONSTRAINT FK_ENT FOREIGN KEY (id_ent) REFERENCES ENTREPRISE(id_ent)');
    	$this->addSql('ALTER TABLE VALEUR Add CONSTRAINT FK_DATE FOREIGN KEY (id_date) REFERENCES DATE_INFO(id_date)');
    }

    public function down(Schema $schema): void
    {
    	$this->addSql('ALTER TABLE VALEUR DROP FOREIGN KEY FK_ENT');
    	$this->addSql('ALTER TABLE VALEUR DROP FOREIGN KEY FK_DATE');
    	$this->addSql('DROP TABLE VALEUR');
    	$this->addSql('DROP TABLE DATE_INFO');
    	$this->addSql('DROP TABLE ENTREPRISE');
    }
}
