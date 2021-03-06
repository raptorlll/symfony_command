<?php

namespace AppBundle\Service\Import\Mode;

use AppBundle\Entity\ProductData;
use Doctrine\ORM\EntityManager;

class ModeProduction extends ModeAbstract
{
    /**
     * Perform actual saving
     * If error while saving new entity, then add err mark,
     * otherwise success mark
     *
     * @param ProductData $product
     * @param EntityManager $entityManager
     */
    public function saveEntity(ProductData $product, EntityManager $entityManager)
    {
        try{
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addSuccessfullySaved();
        }catch (\Exception $e){
            $this->addErrorSaved($e->getMessage());
        }
    }

    public function getSavingInformation(): string
    {
        return 'Saved in production mode '. parent::getSavingInformation();
    }
}