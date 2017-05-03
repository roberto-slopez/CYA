<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 20/02/16
 * Time: 05:02 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\AbstractQuery;
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
     * @param $packageId
     * @return PackageLodging
     */
    public function getPriceLodgingById($lodgingId, $packageId)
    {
        try {
            $qb = $this->createQueryBuilder('package_lodging');
            $qb->leftJoin('package_lodging.lodging', 'lodging')
                ->leftJoin('package_lodging.package', 'package')
                ->where('lodging.id=:lodgingId')
                ->andWhere('package.id=:packageId')
                ->setParameter('lodgingId', $lodgingId)
                ->setParameter('packageId', $packageId)
                ->setMaxResults(1);

            return $qb->getQuery()->getResult()[0];

        } catch (\Exception $e) {
            return null;
        }
    }
}