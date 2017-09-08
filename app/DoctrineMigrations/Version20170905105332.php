<?php

namespace Application\Migrations;

use AppBundle\Entity\ProductData;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170905105332 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('tblProductData');
        $table->addColumn('stock', Type::INTEGER, [
            'Default'=>0
        ]);
        $table->addColumn('cost', Type::FLOAT, [
            'Default'=>.0
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('tblProductData');
        $table->dropColumn('stock');
        $table->dropColumn('cost');
    }
}
