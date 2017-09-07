<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
