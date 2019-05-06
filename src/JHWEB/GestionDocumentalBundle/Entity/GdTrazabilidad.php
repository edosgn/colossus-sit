<?php

namespace JHWEB\GestionDocumentalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GdTrazabilidad
 *
 * @ORM\Table(name="gd_trazabilidad")
 * @ORM\Entity(repositoryClass="JHWEB\GestionDocumentalBundle\Repository\GdTrazabilidadRepository")
 */
class GdTrazabilidad
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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=50)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_asignacion", type="datetime")
     */
    private $fechaAsignacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_respuesta", type="datetime", nullable=true)
     */
    private $fechaRespuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=225, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(name="aceptada", type="boolean")
     */
    private $aceptada;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="trazabilidades") */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity="GdDocumento", inversedBy="trazabilidades")
     **/
    protected $documento;

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
     * Set estado
     *
     * @param string $estado
     *
     * @return GdTrazabilidad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return GdTrazabilidad
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        if ($this->fechaAsignacion) {
            return $this->fechaAsignacion->format('d/m/Y');
        }
        return $this->fechaAsignacion;
    }

    /**
     * Set fechaRespuesta
     *
     * @param \DateTime $fechaRespuesta
     *
     * @return GdTrazabilidad
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
        if ($this->fechaRespuesta) {
            return $this->fechaRespuesta->format('d/m/Y');
        }
        return $this->fechaRespuesta;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return GdTrazabilidad
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return GdTrazabilidad
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set aceptada
     *
     * @param boolean $aceptada
     *
     * @return GdTrazabilidad
     */
    public function setAceptada($aceptada)
    {
        $this->aceptada = $aceptada;

        return $this;
    }

    /**
     * Get aceptada
     *
     * @return boolean
     */
    public function getAceptada()
    {
        return $this->aceptada;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return GdTrazabilidad
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
     * Set responsable
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $responsable
     *
     * @return GdTrazabilidad
     */
    public function setResponsable(\JHWEB\PersonalBundle\Entity\PnalFuncionario $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set documento
     *
     * @param \JHWEB\GestionDocumentalBundle\Entity\GdDocumento $documento
     *
     * @return GdTrazabilidad
     */
    public function setDocumento(\JHWEB\GestionDocumentalBundle\Entity\GdDocumento $documento = null)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \JHWEB\GestionDocumentalBundle\Entity\GdDocumento
     */
    public function getDocumento()
    {
        return $this->documento;
    }
}
