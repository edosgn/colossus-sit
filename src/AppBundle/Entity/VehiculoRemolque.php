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
     * @ORM\Column(name="pesoVacio", type="string", length=255)
     */
    private $pesoVacio;

    /**
     * @var string
     *
     * @ORM\Column(name="cargaUtil", type="string", length=255)
     */
    private $cargaUtil;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroEjes", type="string", length=255)
     */
    private $numeroEjes;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroFth", type="string", length=255)
     */
    private $numeroFth;

    /**
     * @var string
     *
     * @ORM\Column(name="rut", type="string", length=255)
     */
    private $rut;

    
    /**
     * @var string
     *
     * @ORM\Column(name="alto", type="string", length=255)
     */
    private $alto;

    /**
     * @var string
     *
     * @ORM\Column(name="largo", type="string", length=255)
     */
    private $largo;

    /**
     * @var string
     *
     * @ORM\Column(name="ancho", type="string", length=255)
     */
    private $ancho;



    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\ciudadano", inversedBy="vehiculosRemolques") */
    private $usuario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculosRemolques") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CondicionIngreso", inversedBy="vehiculosRemolques") */
    private $condicionIngreso;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgOrigenRegistro", inversedBy="vehiculosRemolques") */
    private $origenRegistro;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Linea", inversedBy="vehiculosRemolques") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Carroceria", inversedBy="vehiculosRemolques") */
    private $carroceria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgPlaca", inversedBy="vehiculosRemolques") */
    private $placa;

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
     * Set pesoVacio
     *
     * @param string $pesoVacio
     *
     * @return VehiculoRemolque
     */
    public function setPesoVacio($pesoVacio)
    {
        $this->pesoVacio = $pesoVacio;

        return $this;
    }

    /**
     * Get pesoVacio
     *
     * @return string
     */
    public function getPesoVacio()
    {
        return $this->pesoVacio;
    }

    /**
     * Set cargaUtil
     *
     * @param string $cargaUtil
     *
     * @return VehiculoRemolque
     */
    public function setCargaUtil($cargaUtil)
    {
        $this->cargaUtil = $cargaUtil;

        return $this;
    }

    /**
     * Get cargaUtil
     *
     * @return string
     */
    public function getCargaUtil()
    {
        return $this->cargaUtil;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return VehiculoRemolque
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
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
     * Set numeroFth
     *
     * @param string $numeroFth
     *
     * @return VehiculoRemolque
     */
    public function setNumeroFth($numeroFth)
    {
        $this->numeroFth = $numeroFth;

        return $this;
    }

    /**
     * Get numeroFth
     *
     * @return string
     */
    public function getNumeroFth()
    {
        return $this->numeroFth;
    }

    /**
     * Set rut
     *
     * @param string $rut
     *
     * @return VehiculoRemolque
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set alto
     *
     * @param string $alto
     *
     * @return VehiculoRemolque
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return string
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set largo
     *
     * @param string $largo
     *
     * @return VehiculoRemolque
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     *
     * @return VehiculoRemolque
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\ciudadano $usuario
     *
     * @return VehiculoRemolque
     */
    public function setUsuario(\AppBundle\Entity\ciudadano $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\ciudadano
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return VehiculoRemolque
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
     * Set condicionIngreso
     *
     * @param \AppBundle\Entity\CondicionIngreso $condicionIngreso
     *
     * @return VehiculoRemolque
     */
    public function setCondicionIngreso(\AppBundle\Entity\CondicionIngreso $condicionIngreso = null)
    {
        $this->condicionIngreso = $condicionIngreso;

        return $this;
    }

    /**
     * Get condicionIngreso
     *
     * @return \AppBundle\Entity\CondicionIngreso
     */
    public function getCondicionIngreso()
    {
        return $this->condicionIngreso;
    }

    /**
     * Set origenRegistro
     *
     * @param \AppBundle\Entity\CfgOrigenRegistro $origenRegistro
     *
     * @return VehiculoRemolque
     */
    public function setOrigenRegistro(\AppBundle\Entity\CfgOrigenRegistro $origenRegistro = null)
    {
        $this->origenRegistro = $origenRegistro;

        return $this;
    }

    /**
     * Get origenRegistro
     *
     * @return \AppBundle\Entity\CfgOrigenRegistro
     */
    public function getOrigenRegistro()
    {
        return $this->origenRegistro;
    }

    /**
     * Set linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return VehiculoRemolque
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
     * @return VehiculoRemolque
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
     * Set placa
     *
     * @param \AppBundle\Entity\CfgPlaca $placa
     *
     * @return VehiculoRemolque
     */
    public function setPlaca(\AppBundle\Entity\CfgPlaca $placa = null)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return \AppBundle\Entity\CfgPlaca
     */
    public function getPlaca()
    {
        return $this->placa;
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
