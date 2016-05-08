<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Country
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\CountryRepository")
 * @ORM\Table(name="Country", indexes={@ORM\Index(name="fk_Pais_Moneda1_idx", columns={"coin_id"})})
 */
class Country
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
     * @ORM\Column(type="boolean")
     */
    protected $use_health_coverage;

    /**
     * @ORM\Column(type="string")
     */
    protected $coin_id;

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     * @ORM\JoinColumn(name="id", referencedColumnName="country_id", nullable=false)
     */
    protected $cities;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="country")
     * @ORM\JoinColumn(name="id", referencedColumnName="country_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Coin", inversedBy="countries")
     * @ORM\JoinColumn(name="coin_id", referencedColumnName="id", nullable=false)
     */
    protected $coin;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param string $id
     * @return \TS\CYABundle\Entity\Country
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
     * @return mixed
     */
    public function getUseHealthCoverage()
    {
        return $this->use_health_coverage;
    }

    /**
     * @param mixed $use_health_coverage
     */
    public function setUseHealthCoverage($use_health_coverage)
    {
        $this->use_health_coverage = $use_health_coverage;
    }

    /**
     * Set the value of code.
     *
     * @param string $code
     * @return \TS\CYABundle\Entity\Country
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
     * @return \TS\CYABundle\Entity\Country
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
     * @return \TS\CYABundle\Entity\Country
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
     * Set the value of coin_id.
     *
     * @param integer $coin_id
     * @return \TS\CYABundle\Entity\Country
     */
    public function setCoinId($coin_id)
    {
        $this->coin_id = $coin_id;

        return $this;
    }

    /**
     * Get the value of coin_id.
     *
     * @return integer
     */
    public function getCoinId()
    {
        return $this->coin_id;
    }

    /**
     * Add City entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\City $city
     * @return \TS\CYABundle\Entity\Country
     */
    public function addCity(City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove City entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\City $city
     * @return \TS\CYABundle\Entity\Country
     */
    public function removeCity(City $city)
    {
        $this->cities->removeElement($city);

        return $this;
    }

    /**
     * Get City entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Country
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
     * @return \TS\CYABundle\Entity\Country
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
     * Set Coin entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Coin $coin
     * @return \TS\CYABundle\Entity\Country
     */
    public function setCoin(Coin $coin = null)
    {
        $this->coin = $coin;

        return $this;
    }

    /**
     * Get Coin entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Coin
     */
    public function getCoin()
    {
        return $this->coin;
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
        return array('id', 'code', 'name', 'description', 'coin_id');
    }
}