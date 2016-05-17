<?php
/**
 * Author: @roberto-slopez
 * User: tscompany
 * Date: 8/05/16
 * Time: 08:45 AM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use TS\CYABundle\Entity\Agency;

class AgencyRepository  extends EntityRepository
{
    /**
     * @param $limit
     * @return array
     */
    public function getLastRecords($limit)
    {
        $qb = $this->createQueryBuilder('agency');
        $qb->orderBy('agency.updatedAt', 'desc');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}