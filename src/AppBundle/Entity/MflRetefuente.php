<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MflRetefuente
 *
 * @ORM\Table(name="mfl_retefuente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MflRetefuenteRepository")
 */
class MflRetefuente
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
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="documentos") */
    protected $vehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgValorVehiculo", inversedBy="documentos") */
    protected $valorVehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropietarioVehiculo", inversedBy="documentos") */
    protected $propietarioVehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="documentos") */
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
     * @return MflRetefuente
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
     * @return MflRetefuente
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MflRetefuente
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return MflRetefuente
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set valorVehiculo
     *
     * @param \AppBundle\Entity\CfgValorVehiculo $valorVehiculo
     *
     * @return MflRetefuente
     */
    public function setValorVehiculo(\AppBundle\Entity\CfgValorVehiculo $valorVehiculo = null)
    {
        $this->valorVehiculo = $valorVehiculo;

        return $this;
    }

    /**
     * Get valorVehiculo
     *
     * @return \AppBundle\Entity\CfgValorVehiculo
     */
    public function getValorVehiculo()
    {
        return $this->valorVehiculo;
    }

    /**
     * Set propietarioVehiculo
     *
     * @param \AppBundle\Entity\PropietarioVehiculo $propietarioVehiculo
     *
     * @return MflRetefuente
     */
    public function setPropietarioVehiculo(\AppBundle\Entity\PropietarioVehiculo $propietarioVehiculo = null)
    {
        $this->propietarioVehiculo = $propietarioVehiculo;

        return $this;
    }

    /**
     * Get propietarioVehiculo
     *
     * @return \AppBundle\Entity\PropietarioVehiculo
     */
    public function getPropietarioVehiculo()
    {
        return $this->propietarioVehiculo;
    }

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return MflRetefuente
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
