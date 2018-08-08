<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MgdMedidaCautelarVehiculo
 *
 * @ORM\Table(name="mgd_medida_cautelar_vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MgdMedidaCautelarVehiculoRepository")
 */
class MgdMedidaCautelarVehiculo
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
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=10)
     */
    private $placa;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=100)
     */
    private $lugar;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MgdMedidaCautelar", inversedBy="medidasCautelaresVehiculo")
     **/
    protected $medidaCautelar;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="medidasCautelaresVehiculo")
     **/
    protected $clase;
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
     * Set placa
     *
     * @param string $placa
     *
     * @return MgdMedidaCautelarVehiculo
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     *
     * @return MgdMedidaCautelarVehiculo
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MgdMedidaCautelarVehiculo
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
     * Set medidaCautelar
     *
     * @param \AppBundle\Entity\MgdMedidaCautelar $medidaCautelar
     *
     * @return MgdMedidaCautelarVehiculo
     */
    public function setMedidaCautelar(\AppBundle\Entity\MgdMedidaCautelar $medidaCautelar = null)
    {
        $this->medidaCautelar = $medidaCautelar;

        return $this;
    }

    /**
     * Get medidaCautelar
     *
     * @return \AppBundle\Entity\MgdMedidaCautelar
     */
    public function getMedidaCautelar()
    {
        return $this->medidaCautelar;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return MgdMedidaCautelarVehiculo
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }
}
