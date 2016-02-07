<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Client
 *
 * @ORM\Entity(repositoryClass="Repository\ClientRepository")
 * @ORM\Table(name="Client")
 */
class Client
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
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $indentification;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $adress;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $notes;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="client")
     * @ORM\JoinColumn(name="id", referencedColumnName="client_id", nullable=false)
     */
    protected $quotations;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param string $id
     * @return \TS\CYABundle\Entity\Client
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
     * Set the value of first_name.
     *
     * @param string $first_name
     * @return \TS\CYABundle\Entity\Client
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of first_name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the value of last_name.
     *
     * @param string $last_name
     * @return \TS\CYABundle\Entity\Client
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of last_name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the value of indentification.
     *
     * @param string $indentification
     * @return \TS\CYABundle\Entity\Client
     */
    public function setIndentification($indentification)
    {
        $this->indentification = $indentification;

        return $this;
    }

    /**
     * Get the value of indentification.
     *
     * @return string
     */
    public function getIndentification()
    {
        return $this->indentification;
    }

    /**
     * Set the value of telephone.
     *
     * @param string $telephone
     * @return \TS\CYABundle\Entity\Client
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of adress.
     *
     * @param string $adress
     * @return \TS\CYABundle\Entity\Client
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get the value of adress.
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of notes.
     *
     * @param string $notes
     * @return \TS\CYABundle\Entity\Client
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get the value of notes.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add Quotation entity to collection (one to many).
     *
     * @param \TS\CYABundle\Entity\Quotation $quotation
     * @return \TS\CYABundle\Entity\Client
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
     * @return \TS\CYABundle\Entity\Client
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

    public function __sleep()
    {
        return array('id', 'first_name', 'last_name', 'indentification', 'telephone', 'adress', 'notes');
    }
}