<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 20/02/16
 * Time: 05:02 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use TS\CYABundle\Entity\PackageLodging;

/**
 * Class PackageLodgingRepository
 * @package TS\CYABundle\Repository
 */
class PackageLodgingRepository extends EntityRepository
{
    /**
     * @param $lodgingId
     * @return PackageLodging
     */
    public function getPriceLodgingById($lodgingId)
    {
        try {
            $qb = $this->createQueryBuilder('package_lodging');
            $qb->leftJoin('package_lodging.lodging', 'lodging')
                ->where('lodging.id=:lodgingId')
                ->setParameter('lodgingId', $lodgingId)
                ->setMaxResults(1);

            return $qb->getQuery()->getSingleScalarResult();
        } catch (\Exception $e) {
            return null;
        }
    }
}