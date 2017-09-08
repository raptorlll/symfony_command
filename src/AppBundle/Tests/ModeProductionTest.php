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


/**
 * Class ModeProductionTest
 * @package AppBundle\Tests
 */
class ModeProductionTest extends EntityManagerInitialization
{
    use CreateProductDataEntityTrait;
    /***
     * @var $object ModeProduction
     */
    private $object;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new ModeProduction();

    }

    /**
     *
     */
    public function testSaveEntity()
    {

        /** @var ProductDataRepository $productsRepository */
        $productsRepository = $this->entityManager
            ->getRepository(ProductData::class);

        $countBeforeState = $productsRepository->totalCount();

        $this->object->saveEntity($this->createEntity(), $this->entityManager);

        $countAfterState = $productsRepository->totalCount();
        $this->assertEquals($countBeforeState + 1, $countAfterState);
    }


}