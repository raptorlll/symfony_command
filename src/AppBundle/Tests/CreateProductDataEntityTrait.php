<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;



use AppBundle\Entity\ProductData;

trait CreateProductDataEntityTrait
{

    protected function _createEntity() : ProductData{

        $product = new ProductData();
        $product->setProductCode((string) rand(10000, 99999));
        $product->setProductName('TEST');
        $product->setProductDescription('test');
        $product->setStock((int) 23);
        $product->setCost((float) 123);
        $product->setDiscontinued((boolean) 1);

        $dateTime = new \DateTime();
        $product->setDateTimeAdded($dateTime);
        return $product;
    }

}