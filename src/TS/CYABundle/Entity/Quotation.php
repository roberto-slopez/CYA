<?php

namespace TS\CYABundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Entity\Client;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\Quotation
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\QuotationRepository")
 * @ORM\Table(name="Quotation", indexes={@ORM\Index(name="fk_Flexible_Country1_idx", columns={"country_id"}), @ORM\Index(name="fk_Flexible_City1_idx", columns={"city_id"}), @ORM\Index(name="fk_Flexible_headquarters1_idx", columns={"headquarters_id"}), @ORM\Index(name="fk_Flexible_Client1_idx", columns={"client_id"}), @ORM\Index(name="fk_Flexible_Seller1_idx", columns={"seller_id"}), @ORM\Index(name="fk_Flexible_Lodging1_idx", columns={"lodging_id"}), @ORM\Index(name="fk_Quotation_Promociones1_idx", columns={"promociones_id"}), @ORM\Index(name="fk_Quotation_Package1_idx", columns={"package_id"})})
 */
class Quotation
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable;

    const FLEXIBLE = 'FLEXIBLE';
    const PACKAGE = 'PACKAGE';
    const EXAM = 'EXAM';

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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $course_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\Column(type="float", nullable=false)
     */
    protected $amountLodging;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $amountCourse;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $amountService;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $totalUSD;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $totalLocal;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $totalLocalCountry;

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
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="quotations", cascade={"persist"})
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
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="quotations")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=true)
     */
    protected $service;

    /**
     * @ORM\OneToMany(targetEntity="DiscretionarySpending", mappedBy="quotations", cascade={"persist"})
     */
    protected $discretionarySpending;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="quotations")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=true)
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
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id", nullable=true)
     */
    protected $exam;

    public function __construct()
    {
        $this->discretionarySpending = new ArrayCollection();
        $this->service = new ArrayCollection();
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
     * @return mixed
     */
    public function getTotalLocalCountry()
    {
        return $this->totalLocalCountry;
    }

    /**
     * @param mixed $totalLocalCountry
     */
    public function setTotalLocalCountry($totalLocalCountry)
    {
        $this->totalLocalCountry = $totalLocalCountry;
    }

    /**
     * @return mixed
     */
    public function getAmountLodging()
    {
        return $this->amountLodging;
    }

    /**
     * @param $amountLodging
     * @return $this
     */
    public function setAmountLodging($amountLodging)
    {
        $this->amountLodging = $amountLodging;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmountCourse()
    {
        return $this->amountCourse;
    }

    /**
     * @param $amountCourse
     * @return $this
     */
    public function setAmountCourse($amountCourse)
    {
        $this->amountCourse = $amountCourse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmountService()
    {
        return $this->amountService;
    }

    /**
     * @param $amountService
     * @return $this
     */
    public function setAmountService($amountService)
    {
        $this->amountService = $amountService;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalUSD()
    {
        return $this->totalUSD;
    }

    /**
     * @param $totalUSD
     * @return $this
     */
    public function setTotalUSD($totalUSD)
    {
        $this->totalUSD = $totalUSD;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalLocal()
    {
        return $this->totalLocal;
    }

    /**
     * @param $totalLocal
     * @return $this
     */
    public function setTotalLocal($totalLocal)
    {
        $this->totalLocal = $totalLocal;

        return $this;
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
     * @param \TS\CYABundle\Entity\Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get Quotation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @param Service $service
     * @return $this
     */
    public function addService(Service $service)
    {
        $this->service->add($service);

        return $this;
    }

    /**
     * @param Service $service
     * @return $this
     */
    public function removeService(Service $service)
    {
        $this->service->removeElement($service);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param DiscretionarySpending $discretionarySpending
     * @return $this
     */
    public function addDiscretionarySpending(DiscretionarySpending $discretionarySpending)
    {
        $discretionarySpending->setQuotations($this);
        $this->discretionarySpending->add($discretionarySpending);

        return $this;
    }

    /**
     * @param DiscretionarySpending $discretionarySpending
     * @return $this
     */
    public function removeDiscretionarySpending(DiscretionarySpending $discretionarySpending)
    {
        $this->discretionarySpending->removeElement($discretionarySpending);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDiscretionarySpending()
    {
        return $this->discretionarySpending;
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
     * @param \TS\CYABundle\Entity\Promocion $promocion
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
     * @return Exam
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * @param $exam
     * @return $this
     */
    public function setExam($exam)
    {
        $this->exam = $exam;

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
        return array('id', 'country_id', 'city_id', 'headquarters_id', 'client_id', 'seller_id', 'lodging_id', 'service_id', 'course_id', 'semanas', 'note', 'type', 'promociones_id', 'package_id');
    }
}