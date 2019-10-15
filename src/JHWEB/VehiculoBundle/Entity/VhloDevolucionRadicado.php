<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloDevolucionRadicado
 *
 * @ORM\Table(name="vhlo_devolucion_radicado")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloDevolucionRadicadoRepository")
 */
class VhloDevolucionRadicado
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="VhloVehiculo", inversedBy="devoluciones") */
    private $vehiculo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_licencia_transito", type="integer", nullable=true)
     */
    private $numeroLicenciaTransito;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable= true)
     */
    private $fechaIngreso;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_guia_llegada", type="integer", nullable=true)
     */
    private $numeroGuiaLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa_envio", type="string", nullable=true)
     */
    private $empresaEnvio;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set numeroLicenciaTransito
     *
     * @param integer $numeroLicenciaTransito
     *
     * @return VhloDevolucionRadicado
     */
    public function setNumeroLicenciaTransito($numeroLicenciaTransito)
    {
        $this->numeroLicenciaTransito = $numeroLicenciaTransito;

        return $this;
    }

    /**
     * Get numeroLicenciaTransito
     *
     * @return integer
     */
    public function getNumeroLicenciaTransito()
    {
        return $this->numeroLicenciaTransito;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return VhloDevolucionRadicado
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
     * Set numeroGuiaLlegada
     *
     * @param integer $numeroGuiaLlegada
     *
     * @return VhloDevolucionRadicado
     */
    public function setNumeroGuiaLlegada($numeroGuiaLlegada)
    {
        $this->numeroGuiaLlegada = $numeroGuiaLlegada;

        return $this;
    }

    /**
     * Get numeroGuiaLlegada
     *
     * @return integer
     */
    public function getNumeroGuiaLlegada()
    {
        return $this->numeroGuiaLlegada;
    }

    /**
     * Set empresaEnvio
     *
     * @param string $empresaEnvio
     *
     * @return VhloDevolucionRadicado
     */
    public function setEmpresaEnvio($empresaEnvio)
    {
        $this->empresaEnvio = $empresaEnvio;

        return $this;
    }

    /**
     * Get empresaEnvio
     *
     * @return string
     */
    public function getEmpresaEnvio()
    {
        return $this->empresaEnvio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloDevolucionRadicado
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
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloDevolucionRadicado
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
}
