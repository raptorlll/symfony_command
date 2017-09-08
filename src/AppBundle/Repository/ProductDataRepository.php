<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProductDataRepository
 * @package AppBundle\Repository
 */
class ProductDataRepository extends EntityRepository
{

    /**
     * Calculate total count
     * @return int
     */
    public function totalCount(): int{
        return (int) $this->getEntityManager()
            ->createQueryBuilder()
            ->from('AppBundle:ProductData', 'u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
