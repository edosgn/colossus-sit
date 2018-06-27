<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MparqGruaCiudadano
 *
 * @ORM\Table(name="mparq_grua_ciudadano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MparqGruaCiudadanoRepository")
 */
class MparqGruaCiudadano
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
     * @ORM\Column(name="fechaIncio", type="date")
     */
    private $fechaIncio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=10)
     */
    private $tipo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="gruaCiudadanos") */
    private $ciudadano;


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
     * Set fechaIncio
     *
     * @param \DateTime $fechaIncio
     *
     * @return MparqGruaCiudadano
     */
    public function setFechaIncio($fechaIncio)
    {
        $this->fechaIncio = $fechaIncio;

        return $this;
    }

    /**
     * Get fechaIncio
     *
     * @return \DateTime
     */
    public function getFechaIncio()
    {
        return $this->fechaIncio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return MparqGruaCiudadano
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return MparqGruaCiudadano
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return MparqGruaCiudadano
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MparqGruaCiudadano
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return MparqGruaCiudadano
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }
}
