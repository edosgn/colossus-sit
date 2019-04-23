<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacRetefuente
 *
 * @ORM\Table(name="fro_fac_retefuente")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacRetefuenteRepository")
 */
class FroFacRetefuente
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
     * @var string
     *
     * @ORM\Column(name="retencion", type="string", length=255)
     */
    private $retencion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean") 
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="retefuentes") */
    protected $vehiculo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgValor", inversedBy="retefuentes") */
    protected $valorVehiculo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloPropietario", inversedBy="retefuentes") */
    protected $propietario;

    /** @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="retefuentes") */
    protected $factura;


    /**
     * Get id
     *
     * @return integer
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
     * @return FroFacRetefuente
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
        return $this->fecha;
    }

    /**
     * Set retencion
     *
     * @param string $retencion
     *
     * @return FroFacRetefuente
     */
    public function setRetencion($retencion)
    {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * Get retencion
     *
     * @return string
     */
    public function getRetencion()
    {
        return $this->retencion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacRetefuente
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
     * @return FroFacRetefuente
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
     * Set valorVehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgValor $valorVehiculo
     *
     * @return FroFacRetefuente
     */
    public function setValorVehiculo(\JHWEB\VehiculoBundle\Entity\VhloCfgValor $valorVehiculo = null)
    {
        $this->valorVehiculo = $valorVehiculo;

        return $this;
    }

    /**
     * Get valorVehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgValor
     */
    public function getValorVehiculo()
    {
        return $this->valorVehiculo;
    }

    /**
     * Set propietario
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario
     *
     * @return FroFacRetefuente
     */
    public function setPropietario(\JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloPropietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacRetefuente
     */
    public function setFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
