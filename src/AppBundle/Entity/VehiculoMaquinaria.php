<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoMaquinaria
 *
 * @ORM\Table(name="vehiculo_maquinaria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoMaquinariaRepository")
 */
class VehiculoMaquinaria
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
     * @ORM\Column(name="condicionIngreso", type="string", length=255)
     */
    private $condicionIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaIngreso", type="datetime")
     */
    private $fechaIngreso;

     /**
     * @var string
     *
     * @ORM\Column(name="pesoBrutoVehicular", type="string", length=255)
     */
    private $pesoBrutoVehicular;

    /**
     * @var string
     *
     * @ORM\Column(name="cargarUtilMaxima", type="string", length=255)
     */
    private $cargarUtilMaxima;

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
     * @ORM\Column(name="tipoCabina", type="string", length=255)
     */
    private $tipoCabina;

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
     * @var string
     *
     * @ORM\Column(name="subpartidaArancelaria", type="string", length=255)
     */
    private $subpartidaArancelaria;




    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoVehiculo", inversedBy="propietariosVehiculo") */
    private $tipoVehiculo;
    
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgOrigenRegistro", inversedBy="propietariosVehiculo") */
    private $cfgOrigenRegistro;

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
     * Set condicionIngreso
     *
     * @param string $condicionIngreso
     *
     * @return VehiculoMaquinaria
     */
    public function setCondicionIngreso($condicionIngreso)
    {
        $this->condicionIngreso = $condicionIngreso;

        return $this;
    }

    /**
     * Get condicionIngreso
     *
     * @return string
     */
    public function getCondicionIngreso()
    {
        return $this->condicionIngreso;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return VehiculoMaquinaria
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
     * Set pesoBrutoVehicular
     *
     * @param string $pesoBrutoVehicular
     *
     * @return VehiculoMaquinaria
     */
    public function setPesoBrutoVehicular($pesoBrutoVehicular)
    {
        $this->pesoBrutoVehicular = $pesoBrutoVehicular;

        return $this;
    }

    /**
     * Get pesoBrutoVehicular
     *
     * @return string
     */
    public function getPesoBrutoVehicular()
    {
        return $this->pesoBrutoVehicular;
    }

    /**
     * Set cargarUtilMaxima
     *
     * @param string $cargarUtilMaxima
     *
     * @return VehiculoMaquinaria
     */
    public function setCargarUtilMaxima($cargarUtilMaxima)
    {
        $this->cargarUtilMaxima = $cargarUtilMaxima;

        return $this;
    }

    /**
     * Get cargarUtilMaxima
     *
     * @return string
     */
    public function getCargarUtilMaxima()
    {
        return $this->cargarUtilMaxima;
    }

    /**
     * Set rodaje
     *
     * @param string $rodaje
     *
     * @return VehiculoMaquinaria
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
     * @return VehiculoMaquinaria
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
     * @return VehiculoMaquinaria
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
     * Set tipoCabina
     *
     * @param string $tipoCabina
     *
     * @return VehiculoMaquinaria
     */
    public function setTipoCabina($tipoCabina)
    {
        $this->tipoCabina = $tipoCabina;

        return $this;
    }

    /**
     * Get tipoCabina
     *
     * @return string
     */
    public function getTipoCabina()
    {
        return $this->tipoCabina;
    }

    /**
     * Set altoTotal
     *
     * @param string $altoTotal
     *
     * @return VehiculoMaquinaria
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
     * @return VehiculoMaquinaria
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
     * @return VehiculoMaquinaria
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
     * Set subpartidaArancelaria
     *
     * @param string $subpartidaArancelaria
     *
     * @return VehiculoMaquinaria
     */
    public function setSubpartidaArancelaria($subpartidaArancelaria)
    {
        $this->subpartidaArancelaria = $subpartidaArancelaria;

        return $this;
    }

    /**
     * Get subpartidaArancelaria
     *
     * @return string
     */
    public function getSubpartidaArancelaria()
    {
        return $this->subpartidaArancelaria;
    }

    /**
     * Set tipoVehiculo
     *
     * @param \AppBundle\Entity\TipoVehiculo $tipoVehiculo
     *
     * @return VehiculoMaquinaria
     */
    public function setTipoVehiculo(\AppBundle\Entity\TipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \AppBundle\Entity\TipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }

    /**
     * Set cfgOrigenRegistro
     *
     * @param \AppBundle\Entity\CfgOrigenRegistro $cfgOrigenRegistro
     *
     * @return VehiculoMaquinaria
     */
    public function setCfgOrigenRegistro(\AppBundle\Entity\CfgOrigenRegistro $cfgOrigenRegistro = null)
    {
        $this->cfgOrigenRegistro = $cfgOrigenRegistro;

        return $this;
    }

    /**
     * Get cfgOrigenRegistro
     *
     * @return \AppBundle\Entity\CfgOrigenRegistro
     */
    public function getCfgOrigenRegistro()
    {
        return $this->cfgOrigenRegistro;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoMaquinaria
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
