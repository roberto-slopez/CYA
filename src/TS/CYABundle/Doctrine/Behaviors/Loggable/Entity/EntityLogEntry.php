<?php

namespace TS\CYABundle\Doctrine\Behaviors\Loggable\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="entity_log_entry")
 */
class EntityLogEntry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $tabla;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    private $tablaId;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $mensaje;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $createdBy;

    public function __construct(
        $tabla,
        $tablaId,
        $mensaje,
        $createdAt,
        $createdBy
    ) {
        $this->tabla = $tabla;
        $this->tablaId = $tablaId;
        $this->mensaje = $mensaje;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
    }
}
