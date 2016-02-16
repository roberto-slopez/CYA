<?php

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Quotation
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\QuotationRepository")
 * @ORM\Table(name="Quotation", indexes={@ORM\Index(name="fk_Flexible_Country1_idx", columns={"country_id"}), @ORM\Index(name="fk_Flexible_City1_idx", columns={"city_id"}), @ORM\Index(name="fk_Flexible_headquarters1_idx", columns={"headquarters_id"}), @ORM\Index(name="fk_Flexible_Client1_idx", columns={"client_id"}), @ORM\Index(name="fk_Flexible_Seller1_idx", columns={"seller_id"}), @ORM\Index(name="fk_Flexible_Lodging1_idx", columns={"lodging_id"}), @ORM\Index(name="fk_Flexible_Service1_idx", columns={"service_id"}), @ORM\Index(name="fk_Flexible_OptionalService1_idx", columns={"optionalService_id"}), @ORM\Index(name="fk_Flexible_Course1_idx", columns={"course_id"}), @ORM\Index(name="fk_Quotation_Promociones1_idx", columns={"promociones_id"}), @ORM\Index(name="fk_Quotation_Package1_idx", columns={"package_id"})})
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
    protected $country_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $city_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $headquarters_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $client_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $seller_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $lodging_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $service_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $optionalService_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $course_id;

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
    protected $promociones_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $package_id;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="quotations")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="quotations")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Headquarter", inversedBy="quotations")
     * @ORM\JoinColumn(name="headquarters_id", referencedColumnName="id", nullable=false)
     */
    protected $headquarter;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="quotations")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Seller", inversedBy="quotations")
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="id", nullable=false)
     */
    protected $seller;

    /**
     * @ORM\ManyToOne(targetEntity="Lodging", inversedBy="quotations")
     * @ORM\JoinColumn(name="lodging_id", referencedColumnName="id", nullable=false)
     */
    protected $lodging;

    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="quotations")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=false)
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="OptionalService", inversedBy="quotations")
     * @ORM\JoinColumn(name="optionalService_id", referencedColumnName="id", nullable=false)
     */
    protected $optionalService;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="quotations")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     */
    protected $course;

    /**
     * @ORM\ManyToOne(targetEntity="TS\CYABundle\Entity\Promocion", inversedBy="quotations")
     * @ORM\JoinColumn(name="promociones_id", referencedColumnName="id", nullable=true)
     */
    protected $promocion;

    /**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="quotations")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", nullable=true)
     */
    protected $package;

    /**
     * @ORM\ManyToOne(targetEntity="Exam", inversedBy="quotations")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id", nullable=false)
     */
    protected $exam;

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
     * Set the value of country_id.
     *
     * @param integer $country_id
     * @return \TS\CYABundle\Entity\Quotation
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
     * Set the value of city_id.
     *
     * @param integer $city_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;

        return $this;
    }

    /**
     * Get the value of city_id.
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * Set the value of Headquarters_id.
     *
     * @param integer $headquarters_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setHeadquartersId($headquarters_id)
    {
        $this->headquarters_id = $headquarters_id;

        return $this;
    }

    /**
     * Get the value of Headquarters_id.
     *
     * @return integer
     */
    public function getHeadquartersId()
    {
        return $this->headquarters_id;
    }

    /**
     * Set the value of client_id.
     *
     * @param integer $client_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * Get the value of client_id.
     *
     * @return integer
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set the value of Seller_id.
     *
     * @param integer $seller_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setSellerId($seller_id)
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    /**
     * Get the value of Seller_id.
     *
     * @return integer
     */
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * Set the value of Lodging_id.
     *
     * @param integer $lodging_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setLodgingId($lodging_id)
    {
        $this->lodging_id = $lodging_id;

        return $this;
    }

    /**
     * Get the value of lodging_id.
     *
     * @return integer
     */
    public function getLodgingId()
    {
        return $this->lodging_id;
    }

    /**
     * Set the value of Service_id.
     *
     * @param integer $service_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;

        return $this;
    }

    /**
     * Get the value of service_id.
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Set the value of optionalService_id.
     *
     * @param integer $optionalService_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setOptionalServiceId($optionalService_id)
    {
        $this->optionalService_id = $optionalService_id;

        return $this;
    }

    /**
     * Get the value of optionalService_id.
     *
     * @return integer
     */
    public function getOptionalServiceId()
    {
        return $this->optionalService_id;
    }

    /**
     * Set the value of course_id.
     *
     * @param integer $course_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setCourseId($course_id)
    {
        $this->course_id = $course_id;

        return $this;
    }

    /**
     * Get the value of course_id.
     *
     * @return integer
     */
    public function getCourseId()
    {
        return $this->course_id;
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
     * Set the value of promociones_id.
     *
     * @param integer $promociones_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPromocionesId($promociones_id)
    {
        $this->promociones_id = $promociones_id;

        return $this;
    }

    /**
     * Get the value of promociones_id.
     *
     * @return integer
     */
    public function getPromocionesId()
    {
        return $this->promociones_id;
    }

    /**
     * Set the value of package_id.
     *
     * @param integer $package_id
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPackageId($package_id)
    {
        $this->package_id = $package_id;

        return $this;
    }

    /**
     * Get the value of package_id.
     *
     * @return integer
     */
    public function getPackageId()
    {
        return $this->package_id;
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
     * Set Headquarter entity (many to one).
     *
     * @param \TS\CYABundle\Entity\Headquarter $headquarter
     * @return \TS\CYABundle\Entity\Quotation
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
     * @param \TS\CYABundle\Entity\Promocione $promocion
     * @return \TS\CYABundle\Entity\Quotation
     */
    public function setPromocione(Promocion $promocion = null)
    {
        $this->promocion = $promocion;

        return $this;
    }

    /**
     * Get Promocione entity (many to one).
     *
     * @return \TS\CYABundle\Entity\Promocion
     */
    public function getPromocion()
    {
        return $this->promocion;
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
        return array('id', 'country_id', 'city_id', 'headquarters_id', 'client_id', 'seller_id', 'lodging_id', 'service_id', 'optionalService_id', 'course_id', 'semanas', 'note', 'type', 'promociones_id', 'package_id');
    }
}