<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:34 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CityRepository
 * @package TS\CYABundle\Repository
 */
class CityRepository extends EntityRepository
{
    /**
     * @param $countryId
     * @return array
     */
    public function getByCountry($countryId)
    {
        $qb = $this->createQueryBuilder('city');
        $qb->where('city.country_id=:country')
            ->setParameter('country', $countryId);

        return $qb->getQuery()->getResult();
    }
}