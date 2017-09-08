<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 6.9.17
 * Time: 15.42
 */

namespace AppBundle\Tests;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class EntityManagerInitialization
 * @package AppBundle\Tests
 */
class EntityManagerInitialization extends KernelTestCase
{


    /***
     * @var $entityManager EntityManager
     */
    protected $entityManager;


    /**
     *  Setup with getting EntityManager to the
     */
    protected function setUp()
    {

        parent::setUp();
        /**
         * Struggled with issue with Entity manager, because
         * following code did not worked
         * seems that because it can not work correctly with annotations
         * so need more configuration
         */
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $reader = new AnnotationReader();
        $metadataDriver = new AnnotationDriver(
            $reader,
            'Acme\\ProductBundle\\Entity'
        );
        $this->entityManager->getConfiguration()
            ->setMetadataDriverImpl($metadataDriver);

        // allows you to use the AcmeProductBundle:Product syntax
        $this->entityManager->getConfiguration()->setEntityNamespaces(array(
            'AppBundle' => 'AppBundle\\Entity'
        ));
    }



    /**
     * Close connections
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

}