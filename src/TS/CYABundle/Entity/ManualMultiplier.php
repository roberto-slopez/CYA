<?php

namespace TS\CYABundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class ManualMultiplier
 * @package TS\CYABundle\Entity
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\ManualMultiplierRepository")
 * @ORM\Table(name="ManualMultiplier")
 */
class ManualMultiplier
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
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=false)
     */
    protected $service;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Quotation", inversedBy="manualMultiplier")
     * @ORM\JoinColumn(name="quotation_id", referencedColumnName="id", nullable=false)
     */
    protected $quotation;

    /**
     * @return Quotation
     */
    public function getQuotation()
    {
        return $this->quotation;
    }

    /**
     * @param mixed $quotation
     */
    public function setQuotation(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * @return Integer
     */
    public function getPrice()
    {
        return $this->getQuantity() * $this->getService()->getPrice();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}