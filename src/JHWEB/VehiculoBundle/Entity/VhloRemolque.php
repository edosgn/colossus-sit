<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloRemolque
 *
 * @ORM\Table(name="vhlo_remolque")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloRemolqueRepository")
 */
class VhloRemolque
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
     * @var string
     *
     * @ORM\Column(name="peso", type="string", length=255)
     */
    private $peso;

    /**
     * @var string
     *
     * @ORM\Column(name="carga_util_maxima", type="string", length=255)
     */
    private $cargaUtilMaxima;

    /**
     * @var string
     *
     * @ORM\Column(name="alto", type="string", length=255)
     */
    private $alto;

    /**
     * @var string
     *
     * @ORM\Column(name="largo", type="string", length=255)
     */
    private $largo;

    /**
     * @var string
     *
     * @ORM\Column(name="ancho", type="string", length=255)
     */
    private $ancho;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_fth", type="string", length=255)
     */
    private $numeroFth;

    /**
     * @ORM\OneToOne(targetEntity="VhloVehiculo")
     */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="VhloCfgCondicionIngreso", inversedBy="maquinarias") */
    private $condicionIngreso;
    
    /** @ORM\ManyToOne(targetEntity="VhloCfgOrigenRegistro", inversedBy="maquinarias") */
    private $origenRegistro;

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
     * @return VhloRemolque
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
     * Set peso
     *
     * @param string $peso
     *
     * @return VhloRemolque
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set cargaUtilMaxima
     *
     * @param string $cargaUtilMaxima
     *
     * @return VhloRemolque
     */
    public function setCargaUtilMaxima($cargaUtilMaxima)
    {
        $this->cargaUtilMaxima = $cargaUtilMaxima;

        return $this;
    }

    /**
     * Get cargaUtilMaxima
     *
     * @return string
     */
    public function getCargaUtilMaxima()
    {
        return $this->cargaUtilMaxima;
    }

    /**
     * Set alto
     *
     * @param string $alto
     *
     * @return VhloRemolque
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return string
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set largo
     *
     * @param string $largo
     *
     * @return VhloRemolque
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     *
     * @return VhloRemolque
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return VhloRemolque
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set numeroFth
     *
     * @param string $numeroFth
     *
     * @return VhloRemolque
     */
    public function setNumeroFth($numeroFth)
    {
        $this->numeroFth = $numeroFth;

        return $this;
    }

    /**
     * Get numeroFth
     *
     * @return string
     */
    public function getNumeroFth()
    {
        return $this->numeroFth;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloRemolque
     */
    public function setVehiculo(\JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloVehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set condicionIngreso
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso $condicionIngreso
     *
     * @return VhloRemolque
     */
    public function setCondicionIngreso(\JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso $condicionIngreso = null)
    {
        $this->condicionIngreso = $condicionIngreso;

        return $this;
    }

    /**
     * Get condicionIngreso
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso
     */
    public function getCondicionIngreso()
    {
        return $this->condicionIngreso;
    }

    /**
     * Set origenRegistro
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro $origenRegistro
     *
     * @return VhloRemolque
     */
    public function setOrigenRegistro(\JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro $origenRegistro = null)
    {
        $this->origenRegistro = $origenRegistro;

        return $this;
    }

    /**
     * Get origenRegistro
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro
     */
    public function getOrigenRegistro()
    {
        return $this->origenRegistro;
    }
}
