<?php

namespace TS\CYABundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

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
            ->setParameter('headquarter_id', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }
}