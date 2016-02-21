<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\ExchangeRateUSD
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\ExchangeRateUSDRepository")
 * @ORM\Table(name="exchangeRateUSD", indexes={@ORM\Index(name="fk_exchangeRateUSD_Moneda1_idx", columns={"coin_id"})})
 */
class ExchangeRateUSD
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
     * @ORM\Column(name="`local`", type="float")
     */
    protected $local;

    /**
     * @ORM\Column(name="`date`", type="date")
     */
    protected $date;

    /**
     * @ORM\Column(name="`expiration`", type="date")
     */
    protected $expiration;

    /**
     * @ORM\Column(name="`enable`", type="boolean", options={"default": 1})
     */
    protected $enable;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $coin_id;

    /**
     * @ORM\ManyToOne(targetEntity="Coin", inversedBy="exchangeRateUSDs")
     * @ORM\JoinColumn(name="coin_id", referencedColumnName="id", nullable=true)
     */
    protected $coin;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\ExchangeRateUSD
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
     * Set the value of local.
     *
     * @param float $local
     * @return \TS\CYABundle\Entity\ExchangeRateUSD
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get the value of local.
     *
     * @return float
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set the value of date.
     *
     * @param \DateTime $date
     * @return \TS\CYABundle\Entity\ExchangeRateUSD
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of coin_id.
     *
     * @param integer $coin_id
     * @return \TS\CYABundle\Entity\ExchangeRateUSD
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
     * Set Coin entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Coin $coin
     * @return \TS\CYABundle\Entity\ExchangeRateUSD
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
     * @return mixed
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * @param $enable
     * @return $this
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param $expiration
     * @return $this
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function __sleep()
    {
        return array('id', 'local', 'date', 'coin_id');
    }
}