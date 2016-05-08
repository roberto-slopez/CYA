<?php
/**
 * Author: @roberto-slopez
 * User: tscompany
 * Date: 8/05/16
 * Time: 08:43 AM
 */

namespace TS\CYABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use TS\CYABundle\Doctrine\Behaviors\Loggable\Loggable as MoocAdminBundleLoggableTrait;

/**
 * Class Agency
 * @package TS\CYABundle\Entity
 * @ORM\Entity(repositoryClass="TS\CYABundle\Repository\AgencyRepository")
 * @ORM\Table(name="Agency")
 */
class Agency
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
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="summer_schedule_start", type="date")
     */
    protected $sumerScheduleStart;

    /**
     * @ORM\Column(name="summer_schedule_end", type="date")
     */
    protected $sumerScheduleEnd;

    /**
     * Check that today is between start & end
     * @return bool
     */
    public function isSumerSchedule()
    {
        $today = new \DateTime('today');
        $start = $this->getSumerScheduleStart();
        $end = $this->getSumerScheduleEnd();

        return (($today->getTimestamp() >= $start->getTimestamp()) && ($today->getTimestamp() <= $end->getTimestamp()));
    }

    /**
     * @return mixed
     */
    public function getSumerScheduleEnd()
    {
        return $this->sumerScheduleEnd;
    }

    /**
     * @param $sumerScheduleEnd
     * @return $this
     */
    public function setSumerScheduleEnd($sumerScheduleEnd)
    {
        $this->sumerScheduleEnd = $sumerScheduleEnd;

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
     * @return mixed
     */
    public function getSumerScheduleStart()
    {
        return $this->sumerScheduleStart;
    }

    /**
     * @param $sumerScheduleStart
     * @return $this
     */
    public function setSumerScheduleStart($sumerScheduleStart)
    {
        $this->sumerScheduleStart = $sumerScheduleStart;

        return $this;
    }

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
}