<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170908081006 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
          ALTER TABLE `tblProductData` 
            CHANGE COLUMN `stock` `intStock` 
              INTEGER NOT NULL, 
            CHANGE COLUMN `cost` `floatCost` 
              FLOAT NOT NULL;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
          ALTER TABLE `tblProductData` 
            CHANGE COLUMN `intStock` `stock` 
              INTEGER NOT NULL, 
            CHANGE COLUMN `floatCost` `cost` 
              FLOAT NOT NULL;
        ');
    }
}
