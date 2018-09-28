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

    /**
     * @var string
     *
     * @ORM\Column(name="numeroEjes", type="string", length=255)
     */
    private $numeroEjes;

    /**
     * @var string
     *
     * @ORM\Column(name="cargaUtil", type="string", length=255)
     */
    private $cargaUtil;

    /**
     * @var string
     *
     * @ORM\Column(name="pesoVacio", type="string", length=255)
     */
    private $pesoVacio;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255)
     */
    private $referencia;

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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Vehiculo")
     */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro", inversedBy="remolques") */
    private $origenRegistro;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso", inversedBy="remolques") */
    private $condicionIngreso;

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

    /**
     * Set origenRegistro
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro $origenRegistro
     *
     * @return VehiculoRemolque
     */
    public function setOrigenRegistro(\JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro $origenRegistro = null)
    {
        $this->origenRegistro = $origenRegistro;

        return $this;
    }

    /**
     * Get origenRegistro
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgOrigenRegistro
     */
    public function getOrigenRegistro()
    {
        return $this->origenRegistro;
    }

    /**
     * Set condicionIngreso
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso $condicionIngreso
     *
     * @return VehiculoRemolque
     */
    public function setCondicionIngreso(\JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso $condicionIngreso = null)
    {
        $this->condicionIngreso = $condicionIngreso;

        return $this;
    }

    /**
     * Get condicionIngreso
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCondicionIngreso
     */
    public function getCondicionIngreso()
    {
        return $this->condicionIngreso;
    }
}
