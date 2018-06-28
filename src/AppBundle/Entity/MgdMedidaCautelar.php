<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MgdMedidaCautelar
 *
 * @ORM\Table(name="mgd_medida_cautelar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MgdMedidaCautelarRepository")
 */
class MgdMedidaCautelar
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
     * @ORM\Column(name="numeroOficio", type="string", length=50)
     */
    private $numeroOficio;

    /**
     * @var string
     *
     * @ORM\Column(name="quienOrdena", type="string", length=255)
     */
    private $quienOrdena;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date")
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="implicadoIdentificacion", type="string", length=20)
     */
    private $implicadoIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="delito", type="string", length=100)
     */
    private $delito;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=10, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MgdDocumento", inversedBy="medidasCautelares")
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
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return MgdMedidaCautelar
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return string
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
    }

    /**
     * Set quienOrdena
     *
     * @param string $quienOrdena
     *
     * @return MgdMedidaCautelar
     */
    public function setQuienOrdena($quienOrdena)
    {
        $this->quienOrdena = $quienOrdena;

        return $this;
    }

    /**
     * Get quienOrdena
     *
     * @return string
     */
    public function getQuienOrdena()
    {
        return $this->quienOrdena;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return MgdMedidaCautelar
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return MgdMedidaCautelar
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set implicadoIdentificacion
     *
     * @param string $implicadoIdentificacion
     *
     * @return MgdMedidaCautelar
     */
    public function setImplicadoIdentificacion($implicadoIdentificacion)
    {
        $this->implicadoIdentificacion = $implicadoIdentificacion;

        return $this;
    }

    /**
     * Get implicadoIdentificacion
     *
     * @return string
     */
    public function getImplicadoIdentificacion()
    {
        return $this->implicadoIdentificacion;
    }

    /**
     * Set delito
     *
     * @param string $delito
     *
     * @return MgdMedidaCautelar
     */
    public function setDelito($delito)
    {
        $this->delito = $delito;

        return $this;
    }

    /**
     * Get delito
     *
     * @return string
     */
    public function getDelito()
    {
        return $this->delito;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MgdMedidaCautelar
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return MgdMedidaCautelar
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
     * Set documento
     *
     * @param \AppBundle\Entity\MgdDocumento $documento
     *
     * @return MgdMedidaCautelar
     */
    public function setDocumento(\AppBundle\Entity\MgdDocumento $documento = null)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \AppBundle\Entity\MgdDocumento
     */
    public function getDocumento()
    {
        return $this->documento;
    }
}
