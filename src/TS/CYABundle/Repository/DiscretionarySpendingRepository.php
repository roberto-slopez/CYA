<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:46 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class DiscretionarySpending
 * @package TS\CYABundle\Repository
 */
class DiscretionarySpendingRepository extends EntityRepository
{
    /**
     * @param $countryId
     * @return array
     */
    public function getByCountry($countryId)
    {
        $qb = $this->createQueryBuilder('discretionary_spending')
            ->join('discretionary_spending.country', 'country')
            ->where('country.id =:country')
            ->setParameter('country', $countryId)
            ->orderBy('discretionary_spending.name', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }
}