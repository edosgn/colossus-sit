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
     * @ORM\Column(name="origenVehiculo", type="string", length=255)
     */
    private $origenVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="subpartidaArancelaria", type="string", length=255)
     */
    private $subpartidaArancelaria;




    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color", inversedBy="propietariosVehiculo") */
    private $color;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoVehiculo", inversedBy="propietariosVehiculo") */
    private $tipoVehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marca", inversedBy="propietariosVehiculo") */
    private $marca;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="propietariosVehiculo") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Linea", inversedBy="propietariosVehiculo") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Carroceria", inversedBy="propietariosVehiculo") */
    private $carroceria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Combustible", inversedBy="propietariosVehiculo") */
    private $combustible;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="propietariosVehiculo") */
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
     * Set origenVehiculo
     *
     * @param string $origenVehiculo
     *
     * @return VehiculoMaquinaria
     */
    public function setOrigenVehiculo($origenVehiculo)
    {
        $this->origenVehiculo = $origenVehiculo;

        return $this;
    }

    /**
     * Get origenVehiculo
     *
     * @return string
     */
    public function getOrigenVehiculo()
    {
        return $this->origenVehiculo;
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
     * Set color
     *
     * @param \AppBundle\Entity\Color $color
     *
     * @return VehiculoMaquinaria
     */
    public function setColor(\AppBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \AppBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
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
     * Set marca
     *
     * @param \AppBundle\Entity\Marca $marca
     *
     * @return VehiculoMaquinaria
     */
    public function setMarca(\AppBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \AppBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return VehiculoMaquinaria
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

    /**
     * Set linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return VehiculoMaquinaria
     */
    public function setLinea(\AppBundle\Entity\Linea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \AppBundle\Entity\Linea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set carroceria
     *
     * @param \AppBundle\Entity\Carroceria $carroceria
     *
     * @return VehiculoMaquinaria
     */
    public function setCarroceria(\AppBundle\Entity\Carroceria $carroceria = null)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return \AppBundle\Entity\Carroceria
     */
    public function getCarroceria()
    {
        return $this->carroceria;
    }

    /**
     * Set combustible
     *
     * @param \AppBundle\Entity\Combustible $combustible
     *
     * @return VehiculoMaquinaria
     */
    public function setCombustible(\AppBundle\Entity\Combustible $combustible = null)
    {
        $this->combustible = $combustible;

        return $this;
    }

    /**
     * Get combustible
     *
     * @return \AppBundle\Entity\Combustible
     */
    public function getCombustible()
    {
        return $this->combustible;
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
