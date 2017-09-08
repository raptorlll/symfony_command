<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;


use AppBundle\Service\Import\Mode\ModeAbstract;
use PHPUnit\Framework\TestCase;

/**
 * Class ModeAbstractTest
 * @package AppBundle\Tests
 */
class ModeAbstractTest extends TestCase
{
    /***
     * @var $object ModeAbstract
     */
    private $object;

    /**
     * @return int
     */
    private function generateSuccesses(): int
    {
        $count = rand(10, 20);

        for ($i = 0; $i < $count; $i++) {
            $this->object->addSuccessfullySaved('');
        }
        return $count;
    }

    /**
     * @return int
     */
    private function generateErrors(): int
    {
        $count = rand(10, 20);

        for ($i = 0; $i < $count; $i++) {
            $this->object->addErrorSaved('');
        }
        return $count;
    }

    /**
     *
     */
    protected function setUp()
    {
        $stub = $this->getMockForAbstractClass('AppBundle\Service\Import\Mode\ModeAbstract');
        $this->object = $stub;
    }

    /**
     *
     */
    public function testAddErrorSaved()
    {
        $count = $this->generateErrors();

        $this->assertAttributeCount($count, 'errorSaved', $this->object);
    }

    /**
     *
     */
    public function testAddSuccessfullySaved()
    {
        $count = $this->generateSuccesses();

        $this->assertAttributeCount($count, 'successSaved', $this->object);
    }


    /**
     *
     */
    public function testGetSavingInformation(){

        $this->generateErrors();
        $this->generateSuccesses();

        $strSuccess = $this->object->getSavingInformation();
        $this->assertInternalType('string', $strSuccess);

        $strError = $this->object->getErrorInformation();
        $this->assertInternalType('string', $strError);
    }
}