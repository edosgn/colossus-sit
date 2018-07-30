<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoLimitacion
 *
 * @ORM\Table(name="vehiculo_limitacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoLimitacionRepository")
 */
class VehiculoLimitacion
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LimitacionDatos", inversedBy="vehiculosLimitaciones")
     **/
    protected $limitacionDatos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="tramitesSolicitud")
     **/
    protected $vehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return VehiculoLimitacion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set limitacionDatos
     *
     * @param \AppBundle\Entity\LimitacionDatos $limitacionDatos
     *
     * @return VehiculoLimitacion
     */
    public function setLimitacionDatos(\AppBundle\Entity\LimitacionDatos $limitacionDatos = null)
    {
        $this->limitacionDatos = $limitacionDatos;

        return $this;
    }

    /**
     * Get limitacionDatos
     *
     * @return \AppBundle\Entity\LimitacionDatos
     */
    public function getLimitacionDatos()
    {
        return $this->limitacionDatos;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoLimitacion
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
}
