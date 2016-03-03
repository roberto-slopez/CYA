<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 14/02/16
 * Time: 03:23 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ExamRepository
 * @package TS\CYABundle\Repository
 */
class ExamRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('exam');
        $qb->where('exam.headquarters_id=:headquartersId')
            ->setParameter('headquartersId', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->createQueryBuilder('exam')
            ->select('count(exam.id)')
            ->getQuery()->getSingleScalarResult();
    }
}