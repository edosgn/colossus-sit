<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvInvestigacionBien
 *
 * @ORM\Table(name="cv_investigacion_bien")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvInvestigacionBienRepository")
 */
class CvInvestigacionBien
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\Column(name="avaluo", type="integer")
     */
    private $avaluo;

    /**
     * @var bool
     *
     * @ORM\Column(name="embargable", type="boolean")
     */
    private $embargable;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /** @ORM\ManyToOne(targetEntity="CvCdoTrazabilidad", inversedBy="investigaciones") */
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CvInvestigacionBien
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return CvInvestigacionBien
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set avaluo
     *
     * @param integer $avaluo
     *
     * @return CvInvestigacionBien
     */
    public function setAvaluo($avaluo)
    {
        $this->avaluo = $avaluo;

        return $this;
    }

    /**
     * Get avaluo
     *
     * @return integer
     */
    public function getAvaluo()
    {
        return $this->avaluo;
    }

    /**
     * Set embargable
     *
     * @param boolean $embargable
     *
     * @return CvInvestigacionBien
     */
    public function setEmbargable($embargable)
    {
        $this->embargable = $embargable;

        return $this;
    }

    /**
     * Get embargable
     *
     * @return boolean
     */
    public function getEmbargable()
    {
        return $this->embargable;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CvInvestigacionBien
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return CvInvestigacionBien
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set trazabilidad
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad $trazabilidad
     *
     * @return CvInvestigacionBien
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
