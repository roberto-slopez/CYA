<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Service
 *
 * @ORM\Entity(repositoryClass="Repository\ServiceRepository")
 * @ORM\Table(name="Service", indexes={@ORM\Index(name="fk_Servicios_Sede1_idx", columns={"headquarters_id"})})
 */
class Service
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
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @ORM\Column(type="string")
     */
    protected $headquarters_id;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="service")
     * @ORM\JoinColumn(name="id", referencedColumnName="Service_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter", inversedBy="services")
     * @ORM\JoinColumn(name="headquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $deadquarter;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Service
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
     * @return \TS\CYABundle\Entity\Service
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
     * @return \TS\CYABundle\Entity\Service
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
     * Set the value of price.
     *
     * @param float $price
     * @return \TS\CYABundle\Entity\Service
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of headquarters_id.
     *
     * @param integer $headquarters_id
     * @return \TS\CYABundle\Entity\Service
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
     * @return \TS\CYABundle\Entity\Service
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
     * @return \TS\CYABundle\Entity\Service
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
     * @return \TS\CYABundle\Entity\Service
     */
    public function setHeadquarter(Headquarter $headquarter = null)
    {
        $this->deadquarter = $headquarter;

        return $this;
    }

    /**
     * Get Headquarter entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function getHeadquarter()
    {
        return $this->deadquarter;
    }

    public function __sleep()
    {
        return array('id', 'name', 'description', 'price', 'headquarters_id');
    }
}