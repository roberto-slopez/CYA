<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-02-07 09:03:01.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TS\CYABundle\Entity\City
 *
 * @ORM\Entity(repositoryClass="Repository\CityRepository")
 * @ORM\Table(name="City", indexes={@ORM\Index(name="fk_Ciudad_Pais_idx", columns={"country_id"})})
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="integer")
     */
    protected $country_id;

    /**
     * @ORM\OneToMany(targetEntity="Deadquarter", mappedBy="city")
     * @ORM\JoinColumn(name="id", referencedColumnName="Ciudad_id", nullable=false)
     */
    protected $deadquarters;

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
        $this->deadquarters = new ArrayCollection();
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
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
     * @return integer
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
     * Add Deadquarter entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Deadquarter $deadquarter
     * @return \TS\CYABundle\Entity\City
     */
    public function addDeadquarter(Deadquarter $deadquarter)
    {
        $this->deadquarters[] = $deadquarter;

        return $this;
    }

    /**
     * Remove Deadquarter entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Deadquarter $deadquarter
     * @return \TS\CYABundle\Entity\City
     */
    public function removeDeadquarter(Deadquarter $deadquarter)
    {
        $this->deadquarters->removeElement($deadquarter);

        return $this;
    }

    /**
     * Get Deadquarter entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeadquarters()
    {
        return $this->deadquarters;
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

    public function __sleep()
    {
        return array('id', 'code', 'name', 'description', 'country_id');
    }
}