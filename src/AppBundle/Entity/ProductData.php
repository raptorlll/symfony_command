<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Validator\Constraints as ProductConstraints;

/**
 * Tblproductdata
 *
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\ProductDataRepository")
 * @ORM\Table(
 *     name="tblProductData",
 *     uniqueConstraints={@ORM\UniqueConstraint(
 *          name="intProductDataId",
 *          columns={"intProductDataId"}
 *     )}
 * )
 * @ProductConstraints\StockCost(
 *     minCost=5,
 *     minStock=10
 * )
 * @UniqueEntity("productCode")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductData
{


    /**
     * @ORM\PrePersist
     * Will execute before saving
     */
    public function doStuffOnPrePersist()
    {
        /**
         * Any stock item marked as discontinued will be imported,
         * but will have the discontinued
         * date set as the current date.
         */
        if($this->discontinued){
            $this->setDateTimeDiscontinued(new \DateTime());
        }

    }

    /**
     * @var integer
     *
     * @ORM\Column(
     *     name="intProductDataId",
     *     type="integer",
     *     nullable=false,
     *     unique=true
     * )
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="strProductCode",
     *     type="string",
     *     length=10,
     *     nullable=false,
     *     unique=true
     * )
     */
    private $productCode;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="strProductName",
     *     type="string",
     *     length=50,
     *     nullable=false
     * )
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="strProductDesc",
     *     type="string",
     *     length=255,
     *     nullable=false
     * )
     */
    private $productDescription;




    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name="dtmAdded",
     *     type="datetime",
     *     nullable=true
     * )
     */
    private $dateTimeAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name="dtmDiscontinued",
     *     type="datetime",
     *     nullable=true
     * )
     */
    private $dateTimeDiscontinued = null;


    /**
     * @var integer
     *
     * @ORM\Column(
     *     name="intStock",
     *     type="integer",
     *     nullable=false
     * )
     */
    private $stock;

    /**
     * @var float
     *
     * @ORM\Column(
     *     name="floatCost",
     *     type="float",
     *     nullable=false,
     *     options={
     *          "default": 0
     *     }
     * )
     * @Assert\LessThan(
     *     value=1000,
     *     message="Stock items should be less then $1000"
     * )
     * @Assert\GreaterThan(
     *     value=0,
     *     message="Cost should not be less then $0"
     * )
     */
    private $cost;


    /**
     * @var bool
     */
    private $discontinued;










    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return bool
     */
    public function isDiscontinued(): bool
    {
        return $this->discontinued;
    }

    /**
     * @param bool $discontinued
     */
    public function setDiscontinued(bool $discontinued)
    {
        $this->discontinued = $discontinued;
    }








    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription)
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName)
    {
        $this->productName = $productName;
    }


    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @return \DateTime
     */
    public function getDateTimeAdded(): \DateTime
    {
        return $this->dateTimeAdded;
    }

    /**
     * @param \DateTime $dateTimeAdded
     */
    public function setDateTimeAdded(\DateTime $dateTimeAdded)
    {
        $this->dateTimeAdded = $dateTimeAdded;
    }

    /**
     * @return \DateTime
     */
    public function getDateTimeDiscontinued(): \DateTime
    {
        return $this->dateTimeDiscontinued;
    }

    /**
     * @param \DateTime $dateTimeDiscontinued
     */
    public function setDateTimeDiscontinued(\DateTime $dateTimeDiscontinued)
    {
        $this->dateTimeDiscontinued = $dateTimeDiscontinued;
    }
}
