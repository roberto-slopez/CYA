<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Headquarter
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\HeadquarterRepository")
 * @ORM\Table(name="Headquarter", indexes={@ORM\Index(name="fk_headquarter_city_1_idx", columns={"city_id"})})
 */
class Headquarter
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable;

    const SCHOOL = "SCHOOL";
    const COLLEGE = "COLLEGE";
    const OTHERS = "OTHERS";

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(name="`name`", type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="`type`", type="string", length=50)
     */
    protected $type = self::SCHOOL;

    /**
     * @ORM\OneToMany(targetEntity="Exam", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $exam;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $courses;

    /**
     * @ORM\OneToMany(targetEntity="Lodging", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $lodgings;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $services;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="headquarters")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="headquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarter_id", nullable=false)
     */
    protected $package;

    public function __construct()
    {
        $this->exam = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->lodgings = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Headquarter
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
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param $package
     * @return $this
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \TS\CYABundle\Entity\Headquarter
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
     * @return \TS\CYABundle\Entity\Headquarter
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
     * Set the value of type.
     *
     * @param string $type
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add Course entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Course $course
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function addCourse(Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove Course entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Course $course
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);

        return $this;
    }

    /**
     * Get Course entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add Course entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Exam $exam
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function addExam(Exam $exam)
    {
        $this->exam[] = $exam;

        return $this;
    }

    /**
     * Remove Course entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Exam $exam
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function removeExam(Exam $exam)
    {
        $this->exam->removeElement($exam);

        return $this;
    }

    /**
     * Get Course entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Add Lodging entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Lodging $lodging
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function addLodging(Lodging $lodging)
    {
        $this->lodgings[] = $lodging;

        return $this;
    }

    /**
     * Remove Lodging entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Lodging $lodging
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function removeLodging(Lodging $lodging)
    {
        $this->lodgings->removeElement($lodging);

        return $this;
    }

    /**
     * Get Lodging entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLodgings()
    {
        return $this->lodgings;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Headquarter
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
     * @return \TS\CYABundle\Entity\Headquarter
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
     * Add Service entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Service $service
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function addService(Service $service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove Service entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Service $service
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function removeService(Service $service)
    {
        $this->services->removeElement($service);

        return $this;
    }

    /**
     * Get Service entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set City entity (many to one).
     *
     * @param \TS\CYABundle\Entity\City $city
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City entity (many to one).
     *
     * @return \TS\CYABundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName() . $this->getId();
    }

    public function __sleep()
    {
        return array('id', 'name', 'description', 'type', 'city_id');
    }
}
