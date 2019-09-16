<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpTarjetaOperacion
 *
 * @ORM\Table(name="vhlo_tp_tarjeta_operacion")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpTarjetaOperacionRepository")
 */
class VhloTpTarjetaOperacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloTpAsignacion", inversedBy="tarjetas") */
    private $asignacion;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="tarjetas") */
    private $vehiculo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

            
    /**
     * @var int
     *
     * @ORM\Column(name="numero_tarjeta_operacion", type="bigint", length=255)
     */
    private $numeroTarjetaOperacion;

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
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return VhloTpTarjetaOperacion
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set numeroTarjetaOperacion
     *
     * @param integer $numeroTarjetaOperacion
     *
     * @return VhloTpTarjetaOperacion
     */
    public function setNumeroTarjetaOperacion($numeroTarjetaOperacion)
    {
        $this->numeroTarjetaOperacion = $numeroTarjetaOperacion;

        return $this;
    }

    /**
     * Get numeroTarjetaOperacion
     *
     * @return integer
     */
    public function getNumeroTarjetaOperacion()
    {
        return $this->numeroTarjetaOperacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTpTarjetaOperacion
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
     * Set asignacion
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloTpAsignacion $asignacion
     *
     * @return VhloTpTarjetaOperacion
     */
    public function setAsignacion(\JHWEB\VehiculoBundle\Entity\VhloTpAsignacion $asignacion = null)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloTpAsignacion
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloTpTarjetaOperacion
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
