<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:45 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ServiceRepository
 * @package TS\CYABundle\Repository
 */
class ServiceRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('service');
        $qb->where('service.headquarters_id=:headquartersId')
            ->setParameter('headquartersId', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }
}