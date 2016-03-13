<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class DiscretionarySpending
 * @package TS\CYABundle\Entity
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\DiscretionarySpendingRepository")
 * @ORM\Table(name="DiscretionarySpending")
 */
class DiscretionarySpending
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
     * @ORM\Column(name="value_visa", type="float", nullable=true)
     */
    protected $valueVisa;

    /**
     * @ORM\Column(name="value_adicional", type="float", nullable=true)
     */
    protected $valueAdicional;

    /**
     * @ORM\Column(name="value_shipping", type="float", nullable=true)
     */
    protected $valueShipping;

    /**
     * @ORM\ManyToOne(targetEntity="Coin")
     * @ORM\JoinColumn(name="coin_id", referencedColumnName="id", nullable=true)
     */
    protected $coin;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    protected $country;

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\DiscretionarySpending
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
     * @return \TS\CYABundle\Entity\DiscretionarySpending
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
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \TS\CYABundle\Entity\DiscretionarySpending
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
     * @return mixed
     */
    public function getValueVisa()
    {
        return $this->valueVisa;
    }

    /**
     * @param mixed $valueVisa
     */
    public function setValueVisa($valueVisa)
    {
        $this->valueVisa = $valueVisa;
    }

    /**
     * @return mixed
     */
    public function getValueAdicional()
    {
        return $this->valueAdicional;
    }

    /**
     * @param mixed $valueAdicional
     */
    public function setValueAdicional($valueAdicional)
    {
        $this->valueAdicional = $valueAdicional;
    }

    /**
     * @return mixed
     */
    public function getValueShipping()
    {
        return $this->valueShipping;
    }

    /**
     * @param mixed $valueShipping
     */
    public function setValueShipping($valueShipping)
    {
        $this->valueShipping = $valueShipping;
    }

    /**
     * @return Coin
     */
    public function getCoin()
    {
        return $this->coin;
    }

    /**
     * @param mixed $coin
     */
    public function setCoin($coin)
    {
        $this->coin = $coin;
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
        return array('id', 'name', 'description', 'price', 'headquarters_id');
    }
}