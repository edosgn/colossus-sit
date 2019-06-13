<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoTrazabilidad
 *
 * @ORM\Table(name="cv_cdo_trazabilidad")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoTrazabilidadRepository")
 */
class CvCdoTrazabilidad
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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo", inversedBy="trazabilidades") */
    private $actoAdministrativo;

    /** @ORM\ManyToOne(targetEntity="CvCdoComparendo", inversedBy="trazabilidades") */
    private $comparendo;

    /**
     * @ORM\ManyToOne(targetEntity="CvCdoCfgEstado", inversedBy="trazabilidades")
     **/
    protected $estado;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CvCdoTrazabilidad
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
         }
        return $this->fecha;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CvCdoTrazabilidad
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoTrazabilidad
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CvCdoTrazabilidad
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set actoAdministrativo
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo $actoAdministrativo
     *
     * @return CvCdoTrazabilidad
     */
    public function setActoAdministrativo(\JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo $actoAdministrativo = null)
    {
        $this->actoAdministrativo = $actoAdministrativo;

        return $this;
    }

    /**
     * Get actoAdministrativo
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo
     */
    public function getActoAdministrativo()
    {
        return $this->actoAdministrativo;
    }

    /**
     * Set comparendo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo
     *
     * @return CvCdoTrazabilidad
     */
    public function setComparendo(\JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set estado
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado
     *
     * @return CvCdoTrazabilidad
     */
    public function setEstado(\JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
