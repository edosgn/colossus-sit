<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MparqEntradaSalida
 *
 * @ORM\Table(name="mparq_entrada_salida")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MparqEntradaSalidaRepository")
 */
class MparqEntradaSalida
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
     * @ORM\Column(name="fechaIngreso", type="datetime")
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaSalida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaSalida", type="time", nullable=true)
     */
    private $horaSalida;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroSalida", type="integer", nullable=true)
     */
    private $numeroSalida;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroInventario", type="integer")
     */
    private $numeroInventario;

    /**
     * @var int
     *
     * @ORM\Column(name="dias", type="integer", nullable=true)
     */
    private $dias;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="valorParqueadero", type="integer", nullable=true)
     */
    private $valorParqueadero;

    /**
     * @var bool
     *
     * @ORM\Column(name="salida", type="boolean")
     */
    private $salida = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\MparqGrua", inversedBy="entradasSalidas") */
    private $grua;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="entradasSalidas") */
    private $comparendo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\MparqCostoTrayecto", inversedBy="entradasSalidas") */
    private $costoTrayecto;


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
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return MparqEntradaSalida
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return MparqEntradaSalida
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set horaSalida
     *
     * @param \DateTime $horaSalida
     *
     * @return MparqEntradaSalida
     */
    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;

        return $this;
    }

    /**
     * Get horaSalida
     *
     * @return \DateTime
     */
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    /**
     * Set numeroSalida
     *
     * @param integer $numeroSalida
     *
     * @return MparqEntradaSalida
     */
    public function setNumeroSalida($numeroSalida)
    {
        $this->numeroSalida = $numeroSalida;

        return $this;
    }

    /**
     * Get numeroSalida
     *
     * @return integer
     */
    public function getNumeroSalida()
    {
        return $this->numeroSalida;
    }

    /**
     * Set numeroInventario
     *
     * @param integer $numeroInventario
     *
     * @return MparqEntradaSalida
     */
    public function setNumeroInventario($numeroInventario)
    {
        $this->numeroInventario = $numeroInventario;

        return $this;
    }

    /**
     * Get numeroInventario
     *
     * @return integer
     */
    public function getNumeroInventario()
    {
        return $this->numeroInventario;
    }

    /**
     * Set dias
     *
     * @param integer $dias
     *
     * @return MparqEntradaSalida
     */
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    /**
     * Get dias
     *
     * @return integer
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return MparqEntradaSalida
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
     * Set valorParqueadero
     *
     * @param integer $valorParqueadero
     *
     * @return MparqEntradaSalida
     */
    public function setValorParqueadero($valorParqueadero)
    {
        $this->valorParqueadero = $valorParqueadero;

        return $this;
    }

    /**
     * Get valorParqueadero
     *
     * @return integer
     */
    public function getValorParqueadero()
    {
        return $this->valorParqueadero;
    }

    /**
     * Set salida
     *
     * @param boolean $salida
     *
     * @return MparqEntradaSalida
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return boolean
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MparqEntradaSalida
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
     * Set grua
     *
     * @param \AppBundle\Entity\MparqGrua $grua
     *
     * @return MparqEntradaSalida
     */
    public function setGrua(\AppBundle\Entity\MparqGrua $grua = null)
    {
        $this->grua = $grua;

        return $this;
    }

    /**
     * Get grua
     *
     * @return \AppBundle\Entity\MparqGrua
     */
    public function getGrua()
    {
        return $this->grua;
    }

    /**
     * Set comparendo
     *
     * @param \AppBundle\Entity\Comparendo $comparendo
     *
     * @return MparqEntradaSalida
     */
    public function setComparendo(\AppBundle\Entity\Comparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \AppBundle\Entity\Comparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set costoTrayecto
     *
     * @param \AppBundle\Entity\MparqCostoTrayecto $costoTrayecto
     *
     * @return MparqEntradaSalida
     */
    public function setCostoTrayecto(\AppBundle\Entity\MparqCostoTrayecto $costoTrayecto = null)
    {
        $this->costoTrayecto = $costoTrayecto;

        return $this;
    }

    /**
     * Get costoTrayecto
     *
     * @return \AppBundle\Entity\MparqCostoTrayecto
     */
    public function getCostoTrayecto()
    {
        return $this->costoTrayecto;
    }
}
