<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;

use AppBundle\Service\Import\CsvParser;
use AppBundle\Service\Import\ImportProducts;
use AppBundle\Service\Import\Mode\ModeFactory;
use AppBundle\Service\Import\Mode\ModeTest;
use AppBundle\Service\Import\Mode\ModeProduction;

use AppBundle\Service\Import\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserFactoryTest
 * @package AppBundle\Tests
 */
class ParserFactoryTest extends TestCase
{
    /**
     *
     */
    public function testGetMode()
    {
        $parser = ParserFactory::getParser('stdsdf.csv');
        $this->assertTrue($parser instanceof CsvParser);
    }

    /**
     * Exception test
     */
    public function testGetModeException()
    {
        $this->expectException(\InvalidArgumentException::class);
        ParserFactory::getParser('asdafs.doc');
    }
}