<?php

namespace TS\CYABundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\LodgingPackage;

class LodgingPackageRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('lodging');
        $qb->innerJoin('lodging.headquarter', 'headquarter')
            ->where('headquarter.id = :headquarter_id')
            ->andWhere('lodging.enable = 1')
            ->setParameter('headquarter_id', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $lodgingId
     * @return LodgingPackage
     */
    public function getPriceLodgingById($lodgingId)
    {
        try {
            $qb = $this->createQueryBuilder('lodging_package');
            $qb->leftJoin('lodging_package.lodging', 'lodging')
                ->where('lodging.id=:lodgingId')
                ->andWhere('lodging.enable = 1')
                ->setParameter('lodgingId', $lodgingId)
                ->setMaxResults(1);

            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }
}