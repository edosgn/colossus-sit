<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCcNotificacion
 *
 * @ORM\Table(name="cv_cc_notificacion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCcNotificacionRepository")
 */
class CvCcNotificacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrega", type="date")
     */
    private $fechaEntrega;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_respuesta", type="date", nullable=true)
     */
    private $fechaRespuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_correo", type="text", nullable=true)
     */
    private $observacionesCorreo;

    /**
     * @var bool
     *
     * @ORM\Column(name="recibio", type="boolean")
     */
    private $recibio;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="CvCdoTrazabilidad", inversedBy="notificaciones") */
    private $trazabilidad;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return CvCcNotificacion
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaEntrega
     *
     * @param \DateTime $fechaEntrega
     *
     * @return CvCcNotificacion
     */
    public function setFechaEntrega($fechaEntrega)
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    /**
     * Get fechaEntrega
     *
     * @return \DateTime
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * Set fechaRespuesta
     *
     * @param \DateTime $fechaRespuesta
     *
     * @return CvCcNotificacion
     */
    public function setFechaRespuesta($fechaRespuesta)
    {
        $this->fechaRespuesta = $fechaRespuesta;

        return $this;
    }

    /**
     * Get fechaRespuesta
     *
     * @return \DateTime
     */
    public function getFechaRespuesta()
    {
        return $this->fechaRespuesta;
    }

    /**
     * Set observacionesCorreo
     *
     * @param string $observacionesCorreo
     *
     * @return CvCcNotificacion
     */
    public function setObservacionesCorreo($observacionesCorreo)
    {
        $this->observacionesCorreo = $observacionesCorreo;

        return $this;
    }

    /**
     * Get observacionesCorreo
     *
     * @return string
     */
    public function getObservacionesCorreo()
    {
        return $this->observacionesCorreo;
    }

    /**
     * Set recibio
     *
     * @param boolean $recibio
     *
     * @return CvCcNotificacion
     */
    public function setRecibio($recibio)
    {
        $this->recibio = $recibio;

        return $this;
    }

    /**
     * Get recibio
     *
     * @return boolean
     */
    public function getRecibio()
    {
        return $this->recibio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCcNotificacion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set trazabilidad
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad $trazabilidad
     *
     * @return CvCcNotificacion
     */
    public function setTrazabilidad(\JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad $trazabilidad = null)
    {
        $this->trazabilidad = $trazabilidad;

        return $this;
    }

    /**
     * Get trazabilidad
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad
     */
    public function getTrazabilidad()
    {
        return $this->trazabilidad;
    }
}
