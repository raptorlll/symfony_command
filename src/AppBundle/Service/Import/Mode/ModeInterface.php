<?php

namespace AppBundle\Service\Import\Mode;

use AppBundle\Entity\ProductData;
use Doctrine\ORM\EntityManager;

interface ModeInterface
{
    public function addErrorSaved(string $errorString);
    public function addSuccessfullySaved(string $errorString);
    public function saveEntity(ProductData $product, EntityManager $entityManager);
    public function getSavingInformation(): string;
    public function getErrorInformation(): string;

}