<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Course
 *
 * @ORM\Entity(repositoryClass="Repository\CourseRepository")
 * @ORM\Table(name="Course", indexes={@ORM\Index(name="fk_Curso_Sede1_idx", columns={"headquarters_id"})})
 */
class Course
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
     * @ORM\Column(name="`name`", type="string", length=150, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="`enable`", type="boolean")
     */
    protected $enable;

    /**
     * @ORM\Column(type="string")
     */
    protected $headquarters_id;

    /**
     * @ORM\OneToMany(targetEntity="AssignmentPriceCourse", mappedBy="course")
     * @ORM\JoinColumn(name="id", referencedColumnName="course_id", nullable=false)
     */
    protected $assignmentPriceCourses;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="course")
     * @ORM\JoinColumn(name="id", referencedColumnName="Course_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Deadquarter", inversedBy="courses")
     * @ORM\JoinColumn(name="headquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $deadquarter;

    public function __construct()
    {
        $this->assignmentPriceCourses = new ArrayCollection();
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Course
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
     * Set the value of name.
     *
     * @param string $name
     * @return \TS\CYABundle\Entity\Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \TS\CYABundle\Entity\Course
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of enable.
     *
     * @param boolean $enable
     * @return \TS\CYABundle\Entity\Course
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get the value of enable.
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set the value of headquarters_id.
     *
     * @param integer $headquarters_id
     * @return \TS\CYABundle\Entity\Course
     */
    public function setHeadquartersId($headquarters_id)
    {
        $this->headquarters_id = $headquarters_id;

        return $this;
    }

    /**
     * Get the value of headquarters_id.
     *
     * @return integer
     */
    public function getHeadquartersId()
    {
        return $this->headquarters_id;
    }

    /**
     * Add AssignmentPriceCourse entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\AssignmentPriceCourse $assignmentPriceCourse
     * @return \TS\CYABundle\Entity\Course
     */
    public function addAssignmentPriceCourse(AssignmentPriceCourse $assignmentPriceCourse)
    {
        $this->assignmentPriceCourses[] = $assignmentPriceCourse;

        return $this;
    }

    /**
     * Remove AssignmentPriceCourse entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\AssignmentPriceCourse $assignmentPriceCourse
     * @return \TS\CYABundle\Entity\Course
     */
    public function removeAssignmentPriceCourse(AssignmentPriceCourse $assignmentPriceCourse)
    {
        $this->assignmentPriceCourses->removeElement($assignmentPriceCourse);

        return $this;
    }

    /**
     * Get AssignmentPriceCourse entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignmentPriceCourses()
    {
        return $this->assignmentPriceCourses;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Course
     */
    public function addQuotation(Quotation $quotation)
    {
        $this->quotations[] = $quotation;

        return $this;
    }

    /**
     * Remove Quotation entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Course
     */
    public function removeQuotation(Quotation $quotation)
    {
        $this->quotations->removeElement($quotation);

        return $this;
    }

    /**
     * Get Quotation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotations()
    {
        return $this->quotations;
    }

    /**
     * Set Deadquarter entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Deadquarter $deadquarter
     * @return \TS\CYABundle\Entity\Course
     */
    public function setDeadquarter(Deadquarter $deadquarter = null)
    {
        $this->deadquarter = $deadquarter;

        return $this;
    }

    /**
     * Get Deadquarter entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Deadquarter
     */
    public function getDeadquarter()
    {
        return $this->deadquarter;
    }

    public function __sleep()
    {
        return array('id', 'name', 'description', 'enable', 'headquarters_id');
    }
}