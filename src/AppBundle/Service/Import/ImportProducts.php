<?php

namespace AppBundle\Service\Import;

use AppBundle\Entity\ProductData;
use AppBundle\Service\Import\Mode\ModeInterface;
use AppBundle\Service\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class ImportProducts
 * @package AppBundle\Service\Import
 */
class ImportProducts
{
    /**
     *
     */
    const MODE_PRODUCTION = 'production';
    const MODE_TEST = 'test';
    const FOLDER = 'importFiles';


    /** @var $entityManager EntityManager */
    private $entityManager;

    /** @var $validator RecursiveValidator */
    private $validator;

    /** @var $mode ModeInterface */
    private $mode;

    public function __construct(EntityManager $entityManager, RecursiveValidator $validator)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }


    /**
     * @param string $path
     * @param ModeInterface $mode
     * @internal param OutputInterface $output
     */
    public function parse(string $path, ModeInterface $mode)
    {
        $this->mode = $mode;
        /** @var CsvParser $parser */
        $parser = ParserFactory::getParser($path);
        /**
         * invoke on new line
         */
        $parser->addObserver([$this, 'newProductHandler']);
        /**
         * Start parsing
         */
        $parser->parse($path);

    }


    /**
     * executes on new column parse event in observable parser
     *
     * @param array $column stored data about products
     */
    public function newProductHandler(array $column)
    {
        $columnPrepared = $this->prepareColumns($column);
        $product = $this->createProductObject($columnPrepared);
        /**
         * Checking errors
         *
         * The biggest issue was that following code
         *
         * $validator = Validation::createValidatorBuilder()
         *            ->enableAnnotationMapping()
         *            ->getValidator();
         *
         * does not support a dependency injection via global scope services
         * or services declared in services.yml,
         * so i can`t use UniqueValidator
         * or Custom validation rules
         *
         * Solution is inject validator to constructor
         */
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            /**
             * add error saving mark
             */
            $errorsArray = [];
            foreach ($errors as $error) {
                /** @var ConstraintViolationInterface $error */
                $errorsArray[] = $error->getMessage();
            }
            $this->mode->addErrorSaved(implode(PHP_EOL, $errorsArray));
        } else {
            /**
             * Save entity or mark as successfully saved
             */
            $this->mode->saveEntity($product, $this->entityManager);
        }

    }

    /**
     * Apply some data manipulations to the input array
     *
     * @param array $column
     * @return array
     */
    private function prepareColumns(array $column): array
    {
        /** columns should not store more then 6 elements */
        $column = array_slice($column, 0, 6);
        /**
         * if columns store less then 6 elements
         * we should add the missing empty elements
         */
        $column = array_replace(array_fill(0, 6, ''), $column);

        return $column;
    }

    /**
     * Create new Product object
     * and fill data from  the array
     *
     * @param array $column
     * @return ProductData
     */
    private function createProductObject(array $column): ProductData
    {
        $product = new ProductData();
        $product->setProductCode($column[0]);
        $product->setProductName($column[1]);
        $product->setProductDescription($column[2]);
        $product->setStock((int)$column[3]);
        $product->setCost((float) str_replace('$', '', $column[4]));
        $product->setDiscontinued((boolean)$column[5]);

        $dateTime = new \DateTime();
        $product->setDateTimeAdded($dateTime);

        return $product;
    }
}