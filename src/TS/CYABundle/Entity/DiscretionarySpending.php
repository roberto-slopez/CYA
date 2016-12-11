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
     * @ORM\Column(name="value_visa", type="float", nullable=true)
     */
    protected $valueVisa;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description_visa;

    /**
     * @ORM\ManyToOne(targetEntity="Coin")
     * @ORM\JoinColumn(name="coin_visa_id", referencedColumnName="id", nullable=true)
     */
    protected $coin_visa;

    /**
     * @ORM\Column(name="value_adicional", type="float", nullable=true)
     */
    protected $valueAdicional;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description_adicional;

    /**
     * @ORM\ManyToOne(targetEntity="Coin")
     * @ORM\JoinColumn(name="coin_adicional_id", referencedColumnName="id", nullable=true)
     */
    protected $coin_adicional;

    /**
     * @ORM\Column(name="value_shipping", type="float", nullable=true)
     */
    protected $valueShipping;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description_shipping;

    /**
     * @ORM\ManyToOne(targetEntity="Coin")
     * @ORM\JoinColumn(name="coin_shipping_id", referencedColumnName="id", nullable=true)
     */
    protected $coin_shipping;

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
     * @return mixed
     */
    public function getDescriptionVisa()
    {
        return $this->description_visa;
    }

    /**
     * @param mixed $description_visa
     */
    public function setDescriptionVisa($description_visa)
    {
        $this->description_visa = $description_visa;
    }

    /**
     * @return mixed
     */
    public function getCoinVisa()
    {
        return $this->coin_visa;
    }

    /**
     * @param mixed $coin_visa
     */
    public function setCoinVisa($coin_visa)
    {
        $this->coin_visa = $coin_visa;
    }

    /**
     * @return mixed
     */
    public function getDescriptionAdicional()
    {
        return $this->description_adicional;
    }

    /**
     * @param mixed $description_adicional
     */
    public function setDescriptionAdicional($description_adicional)
    {
        $this->description_adicional = $description_adicional;
    }

    /**
     * @return mixed
     */
    public function getCoinAdicional()
    {
        return $this->coin_adicional;
    }

    /**
     * @param mixed $coin_adicional
     */
    public function setCoinAdicional($coin_adicional)
    {
        $this->coin_adicional = $coin_adicional;
    }

    /**
     * @return mixed
     */
    public function getDescriptionShipping()
    {
        return $this->description_shipping;
    }

    /**
     * @param mixed $description_shipping
     */
    public function setDescriptionShipping($description_shipping)
    {
        $this->description_shipping = $description_shipping;
    }

    /**
     * @return mixed
     */
    public function getCoinShipping()
    {
        return $this->coin_shipping;
    }

    /**
     * @param mixed $coin_shipping
     */
    public function setCoinShipping($coin_shipping)
    {
        $this->coin_shipping = $coin_shipping;
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName() . $this->getId();
    }
}