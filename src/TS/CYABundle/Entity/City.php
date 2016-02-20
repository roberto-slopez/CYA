<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\City
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\CityRepository")
 * @ORM\Table(name="City", indexes={@ORM\Index(name="fk_Ciudad_Pais_idx", columns={"country_id"})})
 */
class City
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
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(name="`name`", type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $country_id;

    /**
     * @ORM\OneToMany(targetEntity="Headquarter", mappedBy="city")
     * @ORM\JoinColumn(name="id", referencedColumnName="Ciudad_id", nullable=false)
     */
    protected $headquarters;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="city")
     * @ORM\JoinColumn(name="id", referencedColumnName="City_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    protected $country;

    public function __construct()
    {
        $this->headquarters = new ArrayCollection();
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param string $id
     * @return \TS\CYABundle\Entity\City
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of code.
     *
     * @param string $code
     * @return \TS\CYABundle\Entity\City
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \TS\CYABundle\Entity\City
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
     * @return \TS\CYABundle\Entity\City
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
     * Set the value of country_id.
     *
     * @param integer $country_id
     * @return \TS\CYABundle\Entity\City
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * Get the value of country_id.
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Add Headquarter entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Headquarter $headquarter
     * @return \TS\CYABundle\Entity\City
     */
    public function addHeadquarter(Headquarter $headquarter)
    {
        $this->headquarters[] = $headquarter;

        return $this;
    }

    /**
     * Remove Headquarter entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Headquarter $headquarter
     * @return \TS\CYABundle\Entity\City
     */
    public function removeHeadquarter(Headquarter $headquarter)
    {
        $this->headquarters->removeElement($headquarter);

        return $this;
    }

    /**
     * Get Headquarter entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHeadquarters()
    {
        return $this->headquarters;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\City
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
     * @return \TS\CYABundle\Entity\City
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
     * Set Country entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Country $country
     * @return \TS\CYABundle\Entity\City
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName() . $this->getId();
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return array('id', 'code', 'name', 'description', 'country_id');
    }
}