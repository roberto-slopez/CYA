<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Coin
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\CoinRepository")
 * @ORM\Table(name="Coin")
 */
class Coin
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
     * @ORM\Column(type="string", length=20)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=5)
     */
    protected $symbol;

    /**
     * @ORM\Column(name="`name`", type="string", length=45)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Country", mappedBy="coin")
     * @ORM\JoinColumn(name="id", referencedColumnName="coin_id", nullable=false)
     */
    protected $countries;

    /**
     * @ORM\OneToMany(targetEntity="ExchangeRateUSD", mappedBy="coin")
     * @ORM\JoinColumn(name="id", referencedColumnName="coin_id", nullable=true)
     */
    protected $exchangeRateUSDs;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
        $this->exchangeRateUSDs = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param string $id
     * @return \TS\CYABundle\Entity\Coin
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the string of id.
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
     * @return \TS\CYABundle\Entity\Coin
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
     * Set the value of symbol.
     *
     * @param string $symbol
     * @return \TS\CYABundle\Entity\Coin
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get the value of symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \TS\CYABundle\Entity\Coin
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
     * @return \TS\CYABundle\Entity\Coin
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
     * Add Country entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Country $country
     * @return \TS\CYABundle\Entity\Coin
     */
    public function addCountry(Country $country)
    {
        $this->countries[] = $country;

        return $this;
    }

    /**
     * Remove Country entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Country $country
     * @return \TS\CYABundle\Entity\Coin
     */
    public function removeCountry(Country $country)
    {
        $this->countries->removeElement($country);

        return $this;
    }

    /**
     * Get Country entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Add ExchangeRateUSD entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\ExchangeRateUSD $exchangeRateUSD
     * @return \TS\CYABundle\Entity\Coin
     */
    public function addExchangeRateUSD(ExchangeRateUSD $exchangeRateUSD)
    {
        $this->exchangeRateUSDs[] = $exchangeRateUSD;

        return $this;
    }

    /**
     * Remove ExchangeRateUSD entity from collection (one to many).
     *
     * @param \TS\CYABundle\Entity\ExchangeRateUSD $exchangeRateUSD
     * @return \TS\CYABundle\Entity\Coin
     */
    public function removeExchangeRateUSD(ExchangeRateUSD $exchangeRateUSD)
    {
        $this->exchangeRateUSDs->removeElement($exchangeRateUSD);

        return $this;
    }

    /**
     * Get ExchangeRateUSD entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExchangeRateUSDs()
    {
        return $this->exchangeRateUSDs;
    }

    public function __sleep()
    {
        return array('id', 'code', 'symbol', 'name', 'description');
    }
}