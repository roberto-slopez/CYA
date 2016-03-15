<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 14/02/16
 * Time: 03:16 PM
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class Exam
 * @package TS\CYABundle\Entity
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\ExamRepository")
 * @ORM\Table(name="Exam")
 */
class Exam
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
     * @ORM\Column(name="`name`", type="string", length=150, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="`enable`", type="boolean")
     */
    protected $enable;

    /**
     * @ORM\Column(type="float", options={"default": 0})
     */
    protected $price_inscription = 0;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $description_inscription = '';

    /**
     * @ORM\Column(type="string")
     */
    protected $headquarters_id;

    /**
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="exam")
     * @ORM\JoinColumn(name="id", referencedColumnName="exam_id", nullable=false)
     */
    protected $quotations;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter", inversedBy="exam")
     * @ORM\JoinColumn(name="headquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $headquarter;

    /**
     * @ORM\OneToMany(targetEntity="ExamRangeWeeks", mappedBy="exam", cascade={"persist", "remove"})
     */
    protected $examRangeWeeks;

    /**
     * Exam constructor.
     */
    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->examRangeWeeks = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPriceInscription()
    {
        return $this->price_inscription;
    }

    /**
     * @param mixed $price_inscription
     */
    public function setPriceInscription($price_inscription)
    {
        $this->price_inscription = $price_inscription;
    }

    /**
     * @return mixed
     */
    public function getDescriptionInscription()
    {
        return $this->description_inscription;
    }

    /**
     * @param mixed $description_inscription
     */
    public function setDescriptionInscription($description_inscription)
    {
        $this->description_inscription = $description_inscription;
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Exam
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
     * @param ExamRangeWeeks $examRangeWeeks
     * @return $this
     */
    public function addExamRangeWeek(ExamRangeWeeks $examRangeWeeks)
    {
        $examRangeWeeks->setExam($this);
        $this->examRangeWeeks->add($examRangeWeeks);

        return $this;
    }

    /**
     * @param ExamRangeWeeks $examRangeWeeks
     * @return $this
     */
    public function removeExamRangeWeek(ExamRangeWeeks $examRangeWeeks)
    {
        $this->examRangeWeeks->removeElement($examRangeWeeks);

        return $this;
    }

    /**
     * Get Quotation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExamRangeWeeks()
    {
        return $this->examRangeWeeks;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \TS\CYABundle\Entity\Exam
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
     * @return \TS\CYABundle\Entity\Exam
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
     * Set the value of enable.
     *
     * @param boolean $enable
     * @return \TS\CYABundle\Entity\Exam
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get the value of enable.
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set the value of headquarters_id.
     *
     * @param integer $headquarters_id
     * @return \TS\CYABundle\Entity\Exam
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
     * @return \TS\CYABundle\Entity\Exam
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
     * @return \TS\CYABundle\Entity\Exam
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
     * Set Headquarter entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Headquarter $headquarter
     * @return \TS\CYABundle\Entity\Exam
     */
    public function setHeadquarter(Headquarter $headquarter = null)
    {
        $this->headquarter = $headquarter;

        return $this;
    }

    /**
     * Get Headquarter entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Headquarter
     */
    public function getHeadquarter()
    {
        return $this->headquarter;
    }

    public function __sleep()
    {
        return array('id', 'name', 'price', 'description', 'enable', 'headquarters_id');
    }
}