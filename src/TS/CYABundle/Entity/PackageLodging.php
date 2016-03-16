<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 20/02/16
 * Time: 01:56 PM
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * TS\CYABundle\Entity\PackageLodging
 *
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\PackageLodgingRepository")
 * @ORM\Table(name="PackageLodging")
 */
class PackageLodging
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
     * @ORM\Column(name="`name`", type="string", length=15)
     */
    protected $name = 'PackageLodging';

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $lodging_price;

    /**
     * @ORM\ManyToOne(targetEntity="Lodging")
     * @ORM\JoinColumn(name="lodging_id", referencedColumnName="id", nullable=false)
     */
    protected $lodging;

    /**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="packageLodging")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", nullable=true)
     */
    protected $package;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLodgingPrice()
    {
        return $this->lodging_price;
    }

    /**
     * @param $lodging_price
     * @return $this
     */
    public function setLodgingPrice($lodging_price)
    {
        $this->lodging_price = $lodging_price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param $package
     * @return $this
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return Lodging
     */
    public function getLodging()
    {
        return $this->lodging;
    }

    /**
     * @param $lodging
     * @return $this
     */
    public function setLodging($lodging)
    {
        $this->lodging = $lodging;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName() . $this->getId();
    }
}