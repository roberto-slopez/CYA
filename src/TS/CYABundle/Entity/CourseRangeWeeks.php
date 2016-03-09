<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 21/02/16
 * Time: 06:06 PM
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class CourseRangeWeeks
 * @package TS\CYABundle\Entity
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\CourseRangeWeeksRepository")
 * @ORM\Table(name="CourseRangeWeeks")
 */
class CourseRangeWeeks
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable;

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(name="`name`", type="string", length=150)
     */
    protected $name = 'CourseRangeWeeks';

    /**
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    protected $min = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    protected $max = 0;

    /**
     * @ORM\Column(name="greater_than", nullable=true, type="integer", options={"default": 0})
     */
    protected $greaterThan = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="courseRangeWeeks")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=true)
     */
    protected $course;

    public function __construct()
    {
        $this->min = 0;
        $this->max = 0;
        $this->greaterThan = 0;
    }

    /**
     * @param $weeks
     * @return bool
     */
    public function isThisRange($weeks) {

        if ($this->min > 0 && $this->max > 0) {
            if ($weeks >= $this->min && $weeks <= $this->max) {
                return $this->price;
            }
        } elseif ($weeks >= $this->greaterThan && $this->greaterThan > 0) {
            return $this->price;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param $course
     * @return $this
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGreaterThan()
    {
        return $this->greaterThan;
    }

    /**
     * @param $greaterThan
     * @return $this
     */
    public function setGreaterThan($greaterThan)
    {
        $this->greaterThan = $greaterThan;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName() . $this->getId();
    }
}