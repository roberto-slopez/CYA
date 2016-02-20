<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Package
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\PackageRepository")
 * @ORM\Table(name="Package")
 */
class Package
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
     * @ORM\Column(name="`name`", type="string", length=250)
     */
    protected $name;

    /**
     * @ORM\Column(type="float")
     */
    protected $course_price;

    /**
     * @ORM\Column(type="integer")
     */
    protected $semanas;

    /**
     * @ORM\Column(type="string")
     */
    protected $course_id;

    /**
     * @ORM\OneToMany(targetEntity="PackageLodging", mappedBy="package", cascade={"persist"})
     */
    protected $packageLodging;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="package")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     */
    protected $course;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter", inversedBy="package")
     * @ORM\JoinColumn(name="headquarter_id", referencedColumnName="id", nullable=false)
     */
    protected $headquarter;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="package")
     * @ORM\JoinColumn(name="id", referencedColumnName="package_id", nullable=true)
     */
    protected $quotations;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->packageLodging = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCoursePrice()
    {
        return $this->course_price;
    }

    /**
     * @param $course_price
     * @return $this
     */
    public function setCoursePrice($course_price)
    {
        $this->course_price = $course_price;

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
    public function getHeadquarter()
    {
        return $this->headquarter;
    }

    /**
     * @param $headquarter
     * @return $this
     */
    public function setHeadquarter($headquarter)
    {
        $this->headquarter = $headquarter;

        return $this;
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Package
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
     * @return \TS\CYABundle\Entity\Package
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
     * Set the value of semanas.
     *
     * @param integer $semanas
     * @return \TS\CYABundle\Entity\Package
     */
    public function setSemanas($semanas)
    {
        $this->semanas = $semanas;

        return $this;
    }

    /**
     * Get the value of semanas.
     *
     * @return integer
     */
    public function getSemanas()
    {
        return $this->semanas;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Package
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
     * @return \TS\CYABundle\Entity\Package
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
     * @param PackageLodging $packageLodging
     * @return $this
     */
    public function addPackageLodging(PackageLodging $packageLodging)
    {
        $packageLodging->setPackage($this);
        $this->packageLodging->add($packageLodging);

        return $this;
    }

    /**
     * @param PackageLodging $packageLodging
     * @return $this
     */
    public function removePackageLodging(PackageLodging $packageLodging)
    {
        $this->packageLodging->removeElement($packageLodging);

        return $this;
    }

    /**
     * Get Quotation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackageLodging()
    {
        return $this->packageLodging;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) 'Package' . $this->getId();
    }

    public function __sleep()
    {
        return array('id', 'lodging_price', 'name', 'semanas');
    }
}