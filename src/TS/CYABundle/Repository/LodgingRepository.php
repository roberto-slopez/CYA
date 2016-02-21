<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:43 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class LodgingRepository
 * @package TS\CYABundle\Repository
 */
class LodgingRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('lodging');
        $qb->where('lodging.headquarters_id=:headquartersId')
            ->setParameter('headquartersId', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->createQueryBuilder('lodging')
            ->select('count(lodging.id)')
            ->getQuery()->getSingleScalarResult();
    }
}