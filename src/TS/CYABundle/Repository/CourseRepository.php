<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:37 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CourseRepository
 * @package TS\CYABundle\Repository
 */
class CourseRepository extends EntityRepository
{
    /**
     * @param $headquartersId
     * @return array
     */
    public function getByHeadquarter($headquartersId)
    {
        $qb = $this->createQueryBuilder('course');
        $qb->where('course.headquarters_id=:headquartersId')
            ->andWhere('course.enable = 1')
            ->setParameter('headquartersId', $headquartersId);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->createQueryBuilder('course')
            ->select('count(course.id)')
            ->getQuery()->getSingleScalarResult();
    }
}