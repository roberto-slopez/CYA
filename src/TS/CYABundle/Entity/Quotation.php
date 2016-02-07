<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Quotation
 *
 * @ORM\Entity(repositoryClass="Repository\QuotationRepository")
 * @ORM\Table(name="Quotation", indexes={@ORM\Index(name="fk_Flexible_Country1_idx", columns={"Country_id"}), @ORM\Index(name="fk_Flexible_City1_idx", columns={"City_id"}), @ORM\Index(name="fk_Flexible_Deadquarters1_idx", columns={"Deadquarters_id"}), @ORM\Index(name="fk_Flexible_Client1_idx", columns={"Client_id"}), @ORM\Index(name="fk_Flexible_Seller1_idx", columns={"Seller_id"}), @ORM\Index(name="fk_Flexible_Lodging1_idx", columns={"Lodging_id"}), @ORM\Index(name="fk_Flexible_Service1_idx", columns={"Service_id"}), @ORM\Index(name="fk_Flexible_OptionalService1_idx", columns={"OptionalService_id"}), @ORM\Index(name="fk_Flexible_Course1_idx", columns={"Course_id"}), @ORM\Index(name="fk_Quotation_Promociones1_idx", columns={"Promociones_id"}), @ORM\Index(name="fk_Quotation_Package1_idx", columns={"Package_id"})})
 */
class Quotation
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
     * @ORM\Column(type="string")
     */
    protected $Country_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $City_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Deadquarters_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Client_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Seller_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Lodging_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Service_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $OptionalService_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $Course_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $semanas;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $note;

    /**
     * @ORM\Column(name="`type`", type="string", length=150)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Promociones_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $Package_id;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="quotations")
     * @ORM\JoinColumn(name="Country_id", referencedColumnName="id", nullable=false)
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="quotations")
     * @ORM\JoinColumn(name="City_id", referencedColumnName="id", nullable=false)
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Deadquarter", inversedBy="quotations")
     * @ORM\JoinColumn(name="Deadquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $deadquarter;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="quotations")
     * @ORM\JoinColumn(name="Client_id", referencedColumnName="id", nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Seller", inversedBy="quotations")
     * @ORM\JoinColumn(name="Seller_id", referencedColumnName="id", nullable=false)
     */
    protected $seller;

    /**
     * @ORM\ManyToOne(targetEntity="Lodging", inversedBy="quotations")
     * @ORM\JoinColumn(name="Lodging_id", referencedColumnName="id", nullable=false)
     */
    protected $lodging;

    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="quotations")
     * @ORM\JoinColumn(name="Service_id", referencedColumnName="id", nullable=false)
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="OptionalService", inversedBy="quotations")
     * @ORM\JoinColumn(name="OptionalService_id", referencedColumnName="id", nullable=false)
     */
    protected $optionalService;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="quotations")
     * @ORM\JoinColumn(name="Course_id", referencedColumnName="id", nullable=false)
     */
    protected $course;

    /**
     * @ORM\ManyToOne(targetEntity="TS\CYABundle\Entity\Promocione", inversedBy="quotations")
     * @ORM\JoinColumn(name="Promociones_id", referencedColumnName="id", nullable=true)
     */
    protected $promocione;

    /**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="quotations")
     * @ORM\JoinColumn(name="Package_id", referencedColumnName="id", nullable=true)
     */
    protected $package;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \TS\CYABundle\Entity\Quotation
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
     * Set the value of Country_id.
     *
     * @param integer $Country_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCountryId($Country_id)
    {
        $this->Country_id = $Country_id;

        return $this;
    }

    /**
     * Get the value of Country_id.
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->Country_id;
    }

    /**
     * Set the value of City_id.
     *
     * @param integer $City_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCityId($City_id)
    {
        $this->City_id = $City_id;

        return $this;
    }

    /**
     * Get the value of City_id.
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->City_id;
    }

    /**
     * Set the value of Deadquarters_id.
     *
     * @param integer $Deadquarters_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setDeadquartersId($Deadquarters_id)
    {
        $this->Deadquarters_id = $Deadquarters_id;

        return $this;
    }

    /**
     * Get the value of Deadquarters_id.
     *
     * @return integer
     */
    public function getDeadquartersId()
    {
        return $this->Deadquarters_id;
    }

    /**
     * Set the value of Client_id.
     *
     * @param integer $Client_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setClientId($Client_id)
    {
        $this->Client_id = $Client_id;

        return $this;
    }

    /**
     * Get the value of Client_id.
     *
     * @return integer
     */
    public function getClientId()
    {
        return $this->Client_id;
    }

    /**
     * Set the value of Seller_id.
     *
     * @param integer $Seller_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setSellerId($Seller_id)
    {
        $this->Seller_id = $Seller_id;

        return $this;
    }

    /**
     * Get the value of Seller_id.
     *
     * @return integer
     */
    public function getSellerId()
    {
        return $this->Seller_id;
    }

    /**
     * Set the value of Lodging_id.
     *
     * @param integer $Lodging_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setLodgingId($Lodging_id)
    {
        $this->Lodging_id = $Lodging_id;

        return $this;
    }

    /**
     * Get the value of Lodging_id.
     *
     * @return integer
     */
    public function getLodgingId()
    {
        return $this->Lodging_id;
    }

    /**
     * Set the value of Service_id.
     *
     * @param integer $Service_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setServiceId($Service_id)
    {
        $this->Service_id = $Service_id;

        return $this;
    }

    /**
     * Get the value of Service_id.
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->Service_id;
    }

    /**
     * Set the value of OptionalService_id.
     *
     * @param integer $OptionalService_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setOptionalServiceId($OptionalService_id)
    {
        $this->OptionalService_id = $OptionalService_id;

        return $this;
    }

    /**
     * Get the value of OptionalService_id.
     *
     * @return integer
     */
    public function getOptionalServiceId()
    {
        return $this->OptionalService_id;
    }

    /**
     * Set the value of Course_id.
     *
     * @param integer $Course_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCourseId($Course_id)
    {
        $this->Course_id = $Course_id;

        return $this;
    }

    /**
     * Get the value of Course_id.
     *
     * @return integer
     */
    public function getCourseId()
    {
        return $this->Course_id;
    }

    /**
     * Set the value of semanas.
     *
     * @param integer $semanas
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setSemanas($semanas)
    {
        $this->semanas = $semanas;

        return $this;
    }

    /**
     * Get the value of semanas.
     *
     * @return integer
     */
    public function getSemanas()
    {
        return $this->semanas;
    }

    /**
     * Set the value of note.
     *
     * @param string $note
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of note.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of type.
     *
     * @param string $type
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Promociones_id.
     *
     * @param integer $Promociones_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPromocionesId($Promociones_id)
    {
        $this->Promociones_id = $Promociones_id;

        return $this;
    }

    /**
     * Get the value of Promociones_id.
     *
     * @return integer
     */
    public function getPromocionesId()
    {
        return $this->Promociones_id;
    }

    /**
     * Set the value of Package_id.
     *
     * @param integer $Package_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPackageId($Package_id)
    {
        $this->Package_id = $Package_id;

        return $this;
    }

    /**
     * Get the value of Package_id.
     *
     * @return integer
     */
    public function getPackageId()
    {
        return $this->Package_id;
    }

    /**
     * Set Country entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Country $country
     * @return \TS\CYABundle\Entity\Quotation
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
     * Set City entity (many to one).
     *
     * @param \TS\CYABundle\Entity\City $city
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City entity (many to one).
     *
     * @return \TS\CYABundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set Deadquarter entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Deadquarter $deadquarter
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setDeadquarter(Deadquarter $deadquarter = null)
    {
        $this->deadquarter = $deadquarter;

        return $this;
    }

    /**
     * Get Deadquarter entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Deadquarter
     */
    public function getDeadquarter()
    {
        return $this->deadquarter;
    }

    /**
     * Set Client entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Client $client
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get Client entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set Seller entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Seller $seller
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setSeller(Seller $seller = null)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get Seller entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set Lodging entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Lodging $lodging
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setLodging(Lodging $lodging = null)
    {
        $this->lodging = $lodging;

        return $this;
    }

    /**
     * Get Lodging entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Lodging
     */
    public function getLodging()
    {
        return $this->lodging;
    }

    /**
     * Set Service entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Service $service
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setService(Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get Service entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set OptionalService entity (many to one).
     *
     * @param \TS\CYABundle\Entity\OptionalService $optionalService
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setOptionalService(OptionalService $optionalService = null)
    {
        $this->optionalService = $optionalService;

        return $this;
    }

    /**
     * Get OptionalService entity (many to one).
     *
     * @return \TS\CYABundle\Entity\OptionalService
     */
    public function getOptionalService()
    {
        return $this->optionalService;
    }

    /**
     * Set Course entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Course $course
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get Course entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set Promocione entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Promocione $promocione
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPromocione(Promocione $promocione = null)
    {
        $this->promocione = $promocione;

        return $this;
    }

    /**
     * Get Promocione entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Promocione
     */
    public function getPromocione()
    {
        return $this->promocione;
    }

    /**
     * Set Package entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Package $package
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get Package entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    public function __sleep()
    {
        return array('id', 'Country_id', 'City_id', 'Deadquarters_id', 'Client_id', 'Seller_id', 'Lodging_id', 'Service_id', 'OptionalService_id', 'Course_id', 'semanas', 'note', 'type', 'Promociones_id', 'Package_id');
    }
}