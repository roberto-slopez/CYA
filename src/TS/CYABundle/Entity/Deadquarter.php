<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Deadquarter
 *
 * @ORM\Entity(repositoryClass="Repository\DeadquarterRepository")
 * @ORM\Table(name="Deadquarters", indexes={@ORM\Index(name="fk_Sede_Ciudad1_idx", columns={"Ciudad_id"})})
 */
class Deadquarter
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
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $Ciudad_id;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="deadquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $courses;

    /**
     * @ORM\OneToMany(targetEntity="Lodging", mappedBy="deadquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $lodgings;

    /**
     * @ORM\OneToMany(targetEntity="OptionalService", mappedBy="deadquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $optionalServices;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="deadquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="Deadquarters_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="deadquarter")
     * @ORM\JoinColumn(name="id", referencedColumnName="headquarters_id", nullable=false)
     */
    protected $services;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="deadquarters")
     * @ORM\JoinColumn(name="Ciudad_id", referencedColumnName="id", nullable=false)
     */
    protected $city;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->lodgings = new ArrayCollection();
        $this->optionalServices = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * Set the value of Ciudad_id.
     *
     * @param integer $Ciudad_id
     * @return \TS\CYABundle\Entity\Deadquarter
     */
    public function setCiudadId($Ciudad_id)
    {
        $this->Ciudad_id = $Ciudad_id;

        return $this;
    }

    /**
     * Get the value of Ciudad_id.
     *
     * @return integer
     */
    public function getCiudadId()
    {
        return $this->Ciudad_id;
    }

    /**
     * Add Course entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Course $course
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * Add Lodging entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Lodging $lodging
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * Add OptionalService entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\OptionalService $optionalService
     * @return \TS\CYABundle\Entity\Deadquarter
     */
    public function addOptionalService(OptionalService $optionalService)
    {
        $this->optionalServices[] = $optionalService;

        return $this;
    }

    /**
     * Remove OptionalService entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\OptionalService $optionalService
     * @return \TS\CYABundle\Entity\Deadquarter
     */
    public function removeOptionalService(OptionalService $optionalService)
    {
        $this->optionalServices->removeElement($optionalService);

        return $this;
    }

    /**
     * Get OptionalService entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptionalServices()
    {
        return $this->optionalServices;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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
     * @return \TS\CYABundle\Entity\Deadquarter
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

    public function __sleep()
    {
        return array('id', 'name', 'description', 'type', 'Ciudad_id');
    }
}