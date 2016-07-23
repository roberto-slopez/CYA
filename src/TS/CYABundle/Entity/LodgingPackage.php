<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class LodgingPackage
 * @package TS\CYABundle\Entity
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\LodgingPackageRepository")
 * @ORM\Table(name="LodgingPackage")
 */
class LodgingPackage
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
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter")
     * @ORM\JoinColumn(name="headquarter_id", referencedColumnName="id", nullable=true)
     */
    protected $headquarter;

    /**
     * @ORM\ManyToOne(targetEntity="Lodging")
     * @ORM\JoinColumn(name="lodging_id", referencedColumnName="id", nullable=true)
     */
    protected $lodging;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return Lodging
     */
    public function getLodging()
    {
        return $this->lodging;
    }

    /**
     * @param Lodging $lodging
     */
    public function setLodging(Lodging $lodging)
    {
        $this->lodging = $lodging;
    }

    /**
     * @return Headquarter
     */
    public function getHeadquarter()
    {
        return $this->headquarter;
    }

    /**
     * @param Headquarter $headquarter
     */
    public function setHeadquarter(Headquarter $headquarter)
    {
        $this->headquarter = $headquarter;
    }
}