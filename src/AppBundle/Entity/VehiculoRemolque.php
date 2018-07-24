<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoRemolque
 *
 * @ORM\Table(name="vehiculo_remolque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoRemolqueRepository")
 */
class VehiculoRemolque
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
     * @ORM\Column(name="pesoBrutoVehiculo", type="string", length=255)
     */
    private $pesoBrutoVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="cargaUtilMaxima", type="string", length=255)
     */
    private $cargaUtilMaxima;

    /**
     * @var string
     *
     * @ORM\Column(name="rodaje", type="string", length=255)
     */
    private $rodaje;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroEjes", type="string", length=255)
     */
    private $numeroEjes;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroLlantas", type="string", length=255)
     */
    private $numeroLlantas;

    /**
     * @var string
     *
     * @ORM\Column(name="altoTotal", type="string", length=255)
     */
    private $altoTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="largoTotal", type="string", length=255)
     */
    private $largoTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="anchoTotal", type="string", length=255)
     */
    private $anchoTotal;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Vehiculo")
     */
    private $vehiculo;

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
     * Set pesoBrutoVehiculo
     *
     * @param string $pesoBrutoVehiculo
     *
     * @return VehiculoRemolque
     */
    public function setPesoBrutoVehiculo($pesoBrutoVehiculo)
    {
        $this->pesoBrutoVehiculo = $pesoBrutoVehiculo;

        return $this;
    }

    /**
     * Get pesoBrutoVehiculo
     *
     * @return string
     */
    public function getPesoBrutoVehiculo()
    {
        return $this->pesoBrutoVehiculo;
    }

    /**
     * Set cargaUtilMaxima
     *
     * @param string $cargaUtilMaxima
     *
     * @return VehiculoRemolque
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
     * Set rodaje
     *
     * @param string $rodaje
     *
     * @return VehiculoRemolque
     */
    public function setRodaje($rodaje)
    {
        $this->rodaje = $rodaje;

        return $this;
    }

    /**
     * Get rodaje
     *
     * @return string
     */
    public function getRodaje()
    {
        return $this->rodaje;
    }

    /**
     * Set numeroEjes
     *
     * @param string $numeroEjes
     *
     * @return VehiculoRemolque
     */
    public function setNumeroEjes($numeroEjes)
    {
        $this->numeroEjes = $numeroEjes;

        return $this;
    }

    /**
     * Get numeroEjes
     *
     * @return string
     */
    public function getNumeroEjes()
    {
        return $this->numeroEjes;
    }

    /**
     * Set numeroLlantas
     *
     * @param string $numeroLlantas
     *
     * @return VehiculoRemolque
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
     * Set altoTotal
     *
     * @param string $altoTotal
     *
     * @return VehiculoRemolque
     */
    public function setAltoTotal($altoTotal)
    {
        $this->altoTotal = $altoTotal;

        return $this;
    }

    /**
     * Get altoTotal
     *
     * @return string
     */
    public function getAltoTotal()
    {
        return $this->altoTotal;
    }

    /**
     * Set largoTotal
     *
     * @param string $largoTotal
     *
     * @return VehiculoRemolque
     */
    public function setLargoTotal($largoTotal)
    {
        $this->largoTotal = $largoTotal;

        return $this;
    }

    /**
     * Get largoTotal
     *
     * @return string
     */
    public function getLargoTotal()
    {
        return $this->largoTotal;
    }

    /**
     * Set anchoTotal
     *
     * @param string $anchoTotal
     *
     * @return VehiculoRemolque
     */
    public function setAnchoTotal($anchoTotal)
    {
        $this->anchoTotal = $anchoTotal;

        return $this;
    }

    /**
     * Get anchoTotal
     *
     * @return string
     */
    public function getAnchoTotal()
    {
        return $this->anchoTotal;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoRemolque
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
