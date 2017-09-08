<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;

use AppBundle\Service\Import\ImportProducts;
use AppBundle\Service\Import\Mode\ModeFactory;
use AppBundle\Service\Import\Mode\ModeTest;
use AppBundle\Service\Import\Mode\ModeProduction;

use PHPUnit\Framework\TestCase;
class ModeFactoryTest extends TestCase
{
    /**
     *
     */
    public function testGetMode()
    {

        $productionMode = ModeFactory::getMode(ImportProducts::MODE_PRODUCTION);
        $this->assertTrue($productionMode instanceof ModeProduction);

        $productionMode = ModeFactory::getMode(ImportProducts::MODE_TEST);
        $this->assertTrue($productionMode instanceof ModeTest);

    }

    /**
     * Exception test
     */
    public function testGetModeException()
    {
        $this->expectException(\InvalidArgumentException::class);
        ModeFactory::getMode(rand(10000, 100000));
    }
}