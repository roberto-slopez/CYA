<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:40 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class HeadquarterRepository
 * @package TS\CYABundle\Repository
 */
class HeadquarterRepository extends EntityRepository
{
    /**
     * @param $city
     * @return array
     */
    public function getByCity($city)
    {
        $qb = $this->createQueryBuilder('headquarter')
            ->innerJoin('headquarter.city', 'city')
            ->where('city.id = :city_id')
            ->setParameter('city_id', $city);

        return $qb->getQuery()->getArrayResult();
    }
}