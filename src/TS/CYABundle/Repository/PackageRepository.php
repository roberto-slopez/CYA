<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:44 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class PackageRepository
 * @package TS\CYABundle\Repository
 */
class PackageRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('package');
        $qb->leftJoin('package.headquarter', 'headquarter')
            ->where('headquarter.id=:headquartersId')
            ->setParameter('headquartersId', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }


    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->createQueryBuilder('package')
            ->select('count(package.id)')
            ->getQuery()->getSingleScalarResult();
    }
}