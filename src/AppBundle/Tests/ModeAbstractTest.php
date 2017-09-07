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
class ModeAbstractTest extends TestCase
{
    /***
     * @var $_object ModeAbstract
     */
    private $_object;

    /**
     * @return int
     */
    private function _generateSuccesses(): int
    {
        $count = rand(10, 20);

        for ($i = 0; $i < $count; $i++) {
            $this->_object->addSuccessfullySaved('');
        }
        return $count;
    }

    /**
     * @return int
     */
    private function _generateErrors(): int
    {
        $count = rand(10, 20);

        for ($i = 0; $i < $count; $i++) {
            $this->_object->addErrorSaved('');
        }
        return $count;
    }

    protected function setUp()
    {
        $stub = $this->getMockForAbstractClass('AppBundle\Service\Import\Mode\ModeAbstract');
        $this->_object = $stub;
    }

    public function testAddErrorSaved()
    {
        $count = $this->_generateErrors();

        $this->assertAttributeCount($count, 'errorSaved', $this->_object);
    }

    public function testAddSuccessfullySaved()
    {
        $count = $this->_generateSuccesses();

        $this->assertAttributeCount($count, 'successSaved', $this->_object);
    }


    public function testGetSavingInformation(){

        $this->_generateErrors();
        $this->_generateSuccesses();

        $strSuccess = $this->_object->getSavingInformation();
        $this->assertInternalType('string', $strSuccess);

        $strError = $this->_object->getErrorInformation();
        $this->assertInternalType('string', $strError);
    }
}