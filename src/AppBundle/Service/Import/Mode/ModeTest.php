<?php

namespace AppBundle\Service\Import\Mode;

use AppBundle\Entity\ProductData;
use Doctrine\ORM\EntityManager;

class ModeTest extends ModeAbstract
{
    /**
     * @var array
     */
    private $_productDataCodes = [];

    /**
     * Do not do nothing about saving
     * but add success mark
     * or error mask if check that product code already exists
     *
     * @param ProductData $product
     * @param EntityManager $entityManager
     */
    public function saveEntity(ProductData $product, EntityManager $entityManager)
    {
        /**
         * According to the following issue
         * https://github.com/symfony/symfony/issues/17884
         * I cant use UniqueConstraint validation with objects prepared
         * to flushing to the database, so i implement little workaroud
         * for a custom validation
         */
        if(!in_array($product->getProductCode() ,$this->_productDataCodes)){
            $this->_productDataCodes[] = $product->getProductCode();

            $this->addSuccessfullySaved();
        }else{
            $this->addErrorSaved('This value is already used.');
        }
    }

    public function getSavingInformation(): string
    {
        return 'Saved in tested mode '. parent::getSavingInformation();
    }

}