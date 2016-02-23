<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Course
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\CourseRepository")
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
     * @ORM\OneToMany(targetEntity="Package", mappedBy="course")
     * @ORM\JoinColumn(name="id", referencedColumnName="course_id", nullable=false)
     */
    protected $package;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="course")
     * @ORM\JoinColumn(name="id", referencedColumnName="course_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter", inversedBy="courses")
     * @ORM\JoinColumn(name="headquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $headquarter;

    /**
     * @ORM\OneToMany(targetEntity="CourseRangeWeeks", mappedBy="course", cascade={"persist", "remove"})
     */
    protected $courseRangeWeeks;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->package = new ArrayCollection();
        $this->courseRangeWeeks = new ArrayCollection();
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
     * Set Headquarter entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Headquarter $headquarter
     * @return \TS\CYABundle\Entity\Course
     */
    public function setHeadquarter(Headquarter $headquarter = null)
    {
        $this->headquarter = $headquarter;

        return $this;
    }

    /**
     * Get Headquarter entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function getHeadquarter()
    {
        return $this->headquarter;
    }

    /**
     * Add Course entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Package $package
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function addPackage(Package $package)
    {
        $this->package[] = $package;

        return $this;
    }

    /**
     * Remove package entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Package $package
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function removePackage(Package $package)
    {
        $this->package->removeElement($package);

        return $this;
    }

    /**
     * Get Course entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackege()
    {
        return $this->package;
    }

    /**
     * @param CourseRangeWeeks $courseRangeWeeks
     * @return $this
     */
    public function addCourseRangeWeek(CourseRangeWeeks $courseRangeWeeks)
    {
        $courseRangeWeeks->setCourse($this);
        $this->courseRangeWeeks->add($courseRangeWeeks);

        return $this;
    }

    /**
     * @param CourseRangeWeeks $courseRangeWeeks
     * @return $this
     */
    public function removeCourseRangeWeek(CourseRangeWeeks $courseRangeWeeks)
    {
        $this->courseRangeWeeks->removeElement($courseRangeWeeks);

        return $this;
    }

    /**
     * Get Quotation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseRangeWeeks()
    {
        return $this->courseRangeWeeks;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getName().$this->getId();
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return array('id', 'name', 'price', 'description', 'enable', 'headquarters_id');
    }
}