<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;


use AppBundle\Entity\ProductData;
use AppBundle\Repository\ProductDataRepository;
use AppBundle\Service\Import\Mode\ModeProduction;


class ModeProductionTest extends EntityManagerInitialization
{
    use CreateProductDataEntityTrait;
    /***
     * @var $_object ModeProduction
     */
    private $_object;

    protected function setUp()
    {
        parent::setUp();

        $this->_object = new ModeProduction();

    }

    public function testSaveEntity()
    {

        /** @var ProductDataRepository $productsRepository */
        $productsRepository = $this->_entityManager
            ->getRepository(ProductData::class);

        $countBeforeState = $productsRepository->totalCount();

        $this->_object->saveEntity($this->_createEntity(), $this->_entityManager);

        $countAfterState = $productsRepository->totalCount();
        $this->assertEquals($countBeforeState + 1, $countAfterState);
    }


}