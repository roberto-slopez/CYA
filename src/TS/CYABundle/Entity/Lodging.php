<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Lodging
 *
 * @ORM\Entity(repositoryClass="Repository\LodgingRepository")
 * @ORM\Table(name="Lodging", indexes={@ORM\Index(name="fk_Alojamiento_Sede1_idx", columns={"headquarters_id"})})
 */
class Lodging
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
    protected $name;

    /**
     * @ORM\Column(name="`type`", type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\Column(type="float")
     */
    protected $price_per_week;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $headquarters_id;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="lodging")
     * @ORM\JoinColumn(name="id", referencedColumnName="Lodging_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Deadquarter", inversedBy="lodgings")
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
     * @return \TS\CYABundle\Entity\Lodging
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
     * @return \TS\CYABundle\Entity\Lodging
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
     * Set the value of type.
     *
     * @param string $type
     * @return \TS\CYABundle\Entity\Lodging
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
     * Set the value of price_per_week.
     *
     * @param float $price_per_week
     * @return \TS\CYABundle\Entity\Lodging
     */
    public function setPricePerWeek($price_per_week)
    {
        $this->price_per_week = $price_per_week;

        return $this;
    }

    /**
     * Get the value of price_per_week.
     *
     * @return float
     */
    public function getPricePerWeek()
    {
        return $this->price_per_week;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \TS\CYABundle\Entity\Lodging
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
     * Set the value of headquarters_id.
     *
     * @param integer $headquarters_id
     * @return \TS\CYABundle\Entity\Lodging
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
     * @return \TS\CYABundle\Entity\Lodging
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
     * @return \TS\CYABundle\Entity\Lodging
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
     * @return \TS\CYABundle\Entity\Lodging
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
        return array('id', 'name', 'type', 'price_per_week', 'description', 'headquarters_id');
    }
}