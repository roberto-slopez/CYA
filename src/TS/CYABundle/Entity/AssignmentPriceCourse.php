<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-02-07 09:03:01.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TS\CYABundle\Entity\AssignmentPriceCourse
 *
 * @ORM\Entity(repositoryClass="Repository\AssignmentPriceCourseRepository")
 * @ORM\Table(name="AssignmentPriceCourse", indexes={@ORM\Index(name="fk_AssignmentPriceCourse_Curso1_idx", columns={"course_id"}), @ORM\Index(name="fk_AssignmentPriceCourse_PrecioCurso1_idx", columns={"course_price_id"})})
 */
class AssignmentPriceCourse
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $course_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $course_price_id;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="assignmentPriceCourses")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     */
    protected $course;

    /**
     * @ORM\ManyToOne(targetEntity="CoursePrice", inversedBy="assignmentPriceCourses")
     * @ORM\JoinColumn(name="course_price_id", referencedColumnName="id", nullable=false)
     */
    protected $coursePrice;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\AssignmentPriceCourse
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of course_id.
     *
     * @param integer $course_id
     * @return \TS\CYABundle\Entity\AssignmentPriceCourse
     */
    public function setCourseId($course_id)
    {
        $this->course_id = $course_id;

        return $this;
    }

    /**
     * Get the value of course_id.
     *
     * @return integer
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Set the value of course_price_id.
     *
     * @param integer $course_price_id
     * @return \TS\CYABundle\Entity\AssignmentPriceCourse
     */
    public function setCoursePriceId($course_price_id)
    {
        $this->course_price_id = $course_price_id;

        return $this;
    }

    /**
     * Get the value of course_price_id.
     *
     * @return integer
     */
    public function getCoursePriceId()
    {
        return $this->course_price_id;
    }

    /**
     * Set Course entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Course $course
     * @return \TS\CYABundle\Entity\AssignmentPriceCourse
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get Course entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set CoursePrice entity (many to one).
     *
     * @param \TS\CYABundle\Entity\CoursePrice $coursePrice
     * @return \TS\CYABundle\Entity\AssignmentPriceCourse
     */
    public function setCoursePrice(CoursePrice $coursePrice = null)
    {
        $this->coursePrice = $coursePrice;

        return $this;
    }

    /**
     * Get CoursePrice entity (many to one).
     *
     * @return \TS\CYABundle\Entity\CoursePrice
     */
    public function getCoursePrice()
    {
        return $this->coursePrice;
    }

    public function __sleep()
    {
        return array('id', 'course_id', 'course_price_id');
    }
}