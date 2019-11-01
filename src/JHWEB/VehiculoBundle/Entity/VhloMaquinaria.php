<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloMaquinaria
 *
 * @ORM\Table(name="vhlo_maquinaria")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloMaquinariaRepository")
 */
class VhloMaquinaria
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
     * @ORM\Column(name="numero_llantas", type="string", length=255, nullable=true)
     */
    private $numeroLlantas;

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
     * @var int
     *
     * @ORM\Column(name="tipo_dispositivo", type="integer", length=2)
     */
    private $tipoDispositivo;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_importacion", type="string", length=50)
     */
    private $numeroImportacion;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_activacion_gps", type="string", length=255)
     */
    private $numeroActivacionGps;

    /**
     * @ORM\OneToOne(targetEntity="VhloVehiculo")
     */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="VhloCfgTipoMaquinaria", inversedBy="maquinarias") */
    private $tipoMaquinaria;

    /** @ORM\ManyToOne(targetEntity="VhloCfgSubpartidaArancelaria", inversedBy="maquinarias") */
    private $subpartidaArancelaria;

    /** @ORM\ManyToOne(targetEntity="VhloCfgTipoRodaje", inversedBy="maquinarias") */
    private $tipoRodaje;

    /** @ORM\ManyToOne(targetEntity="VhloCfgTipoCabina", inversedBy="maquinarias") */
    private $tipoCabina;

    /** @ORM\ManyToOne(targetEntity="VhloCfgCondicionIngreso", inversedBy="maquinarias") */
    private $condicionIngreso;
    
    /** @ORM\ManyToOne(targetEntity="VhloCfgOrigenRegistro", inversedBy="maquinarias") */
    private $origenRegistro;

    /** @ORM\ManyToOne(targetEntity="VhloCfgEmpresaGps", inversedBy="maquinarias") */
    private $empresaGps;

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
     * @return VhloMaquinaria
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
     * @return VhloMaquinaria
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
     * @return VhloMaquinaria
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
     * Set numeroLlantas
     *
     * @param string $numeroLlantas
     *
     * @return VhloMaquinaria
     */
    public function setNumeroLlantas($numeroLlantas)
    {
        $this->numeroLlantas = $numeroLlantas;

        return $this;
    }

    /**
     * Get numeroLlantas
     *
     * @return string
     */
    public function getNumeroLlantas()
    {
        return $this->numeroLlantas;
    }

    /**
     * Set alto
     *
     * @param string $alto
     *
     * @return VhloMaquinaria
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
     * @return VhloMaquinaria
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
     * @return VhloMaquinaria
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
     * Set tipoDispositivo
     *
     * @param integer $tipoDispositivo
     *
     * @return VhloMaquinaria
     */
    public function setTipoDispositivo($tipoDispositivo)
    {
        $this->tipoDispositivo = $tipoDispositivo;

        return $this;
    }

    /**
     * Get tipoDispositivo
     *
     * @return integer
     */
    public function getTipoDispositivo()
    {
        return $this->tipoDispositivo;
    }

    /**
     * Set numeroImportacion
     *
     * @param string $numeroImportacion
     *
     * @return VhloMaquinaria
     */
    public function setNumeroImportacion($numeroImportacion)
    {
        $this->numeroImportacion = $numeroImportacion;

        return $this;
    }

    /**
     * Get numeroImportacion
     *
     * @return string
     */
    public function getNumeroImportacion()
    {
        return $this->numeroImportacion;
    }

    /**
     * Set numeroActivacionGps
     *
     * @param string $numeroActivacionGps
     *
     * @return VhloMaquinaria
     */
    public function setNumeroActivacionGps($numeroActivacionGps)
    {
        $this->numeroActivacionGps = $numeroActivacionGps;

        return $this;
    }

    /**
     * Get numeroActivacionGps
     *
     * @return string
     */
    public function getNumeroActivacionGps()
    {
        return $this->numeroActivacionGps;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloMaquinaria
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
     * Set tipoMaquinaria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria $tipoMaquinaria
     *
     * @return VhloMaquinaria
     */
    public function setTipoMaquinaria(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria $tipoMaquinaria = null)
    {
        $this->tipoMaquinaria = $tipoMaquinaria;

        return $this;
    }

    /**
     * Get tipoMaquinaria
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria
     */
    public function getTipoMaquinaria()
    {
        return $this->tipoMaquinaria;
    }

    /**
     * Set subpartidaArancelaria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgSubpartidaArancelaria $subpartidaArancelaria
     *
     * @return VhloMaquinaria
     */
    public function setSubpartidaArancelaria(\JHWEB\VehiculoBundle\Entity\VhloCfgSubpartidaArancelaria $subpartidaArancelaria = null)
    {
        $this->subpartidaArancelaria = $subpartidaArancelaria;

        return $this;
    }

    /**
     * Get subpartidaArancelaria
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgSubpartidaArancelaria
     */
    public function getSubpartidaArancelaria()
    {
        return $this->subpartidaArancelaria;
    }

    /**
     * Set tipoRodaje
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoRodaje $tipoRodaje
     *
     * @return VhloMaquinaria
     */
    public function setTipoRodaje(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoRodaje $tipoRodaje = null)
    {
        $this->tipoRodaje = $tipoRodaje;

        return $this;
    }

    /**
     * Get tipoRodaje
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoRodaje
     */
    public function getTipoRodaje()
    {
        return $this->tipoRodaje;
    }

    /**
     * Set tipoCabina
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoCabina $tipoCabina
     *
     * @return VhloMaquinaria
     */
    public function setTipoCabina(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoCabina $tipoCabina = null)
    {
        $this->tipoCabina = $tipoCabina;

        return $this;
    }

    /**
     * Get tipoCabina
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoCabina
     */
    public function getTipoCabina()
    {
        return $this->tipoCabina;
    }

    /**
     * Set condicionIngreso
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso $condicionIngreso
     *
     * @return VhloMaquinaria
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
     * @return VhloMaquinaria
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

    /**
     * Set empresaGps
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgEmpresaGps $empresaGps
     *
     * @return VhloMaquinaria
     */
    public function setEmpresaGps(\JHWEB\VehiculoBundle\Entity\VhloCfgEmpresaGps $empresaGps = null)
    {
        $this->empresaGps = $empresaGps;

        return $this;
    }

    /**
     * Get empresaGps
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgEmpresaGps
     */
    public function getEmpresaGps()
    {
        return $this->empresaGps;
    }
}
