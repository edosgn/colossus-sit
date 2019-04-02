<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloLimitacion
 *
 * @ORM\Table(name="vhlo_limitacion")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloLimitacionRepository")
 */
class VhloLimitacion
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
     * @ORM\ManyToOne(targetEntity="VhloCfgLimitacion", inversedBy="vehiculos")
     **/
    protected $datos;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="limitaciones")
     **/
    protected $vehiculo;

    /**
    * @var boolean
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloLimitacion
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
     * Set datos
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacion $datos
     *
     * @return VhloLimitacion
     */
    public function setDatos(\JHWEB\VehiculoBundle\Entity\VhloCfgLimitacion $datos = null)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLimitacion
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloLimitacion
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
