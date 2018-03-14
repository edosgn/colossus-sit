<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoMedidaCautelar
 *
 * @ORM\Table(name="vehiculo_medida_cautelar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoMedidaCautelarRepository")
 */
class VehiculoMedidaCautelar
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="vehiculosMedidasCautelares")
     **/
    protected $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MedidaCautelar", inversedBy="vehiculosMedidasCautelares")
     **/
    protected $medidaautelar;


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
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoMedidaCautelar
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
     * Set medidaautelar
     *
     * @param \AppBundle\Entity\MedidaCautelar $medidaautelar
     *
     * @return VehiculoMedidaCautelar
     */
    public function setMedidaautelar(\AppBundle\Entity\MedidaCautelar $medidaautelar = null)
    {
        $this->medidaautelar = $medidaautelar;

        return $this;
    }

    /**
     * Get medidaautelar
     *
     * @return \AppBundle\Entity\MedidaCautelar
     */
    public function getMedidaautelar()
    {
        return $this->medidaautelar;
    }
}
