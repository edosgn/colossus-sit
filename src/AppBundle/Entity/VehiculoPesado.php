<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoPesado
 *
 * @ORM\Table(name="vehiculo_pesado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoPesadoRepository")
 */
class VehiculoPesado
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
     * @var int
     *
     * @ORM\Column(name="tonelaje", type="integer")
     */
    private $tonelaje;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroEjes", type="integer")
     */
    private $numeroEjes;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroMt", type="integer")
     */
    private $numeroMt;

    /**
     * @var string
     *
     * @ORM\Column(name="fichaTecnicaHomologacionCarroceria", type="string", length=255)
     */
    private $fichaTecnicaHomologacionCarroceria;

    /**
     * @var string
     *
     * @ORM\Column(name="fichaTecnicaHomologacionChasis", type="string", length=255)
     */
    private $fichaTecnicaHomologacionChasis;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="vehiculosPesado") */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modalidad", inversedBy="vehiculosPesado") */
    private $modalidad;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa", inversedBy="vehiculosPesado") */
    private $empresa;



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
     * Set tonelaje
     *
     * @param integer $tonelaje
     *
     * @return VehiculoPesado
     */
    public function setTonelaje($tonelaje)
    {
        $this->tonelaje = $tonelaje;

        return $this;
    }

    /**
     * Get tonelaje
     *
     * @return integer
     */
    public function getTonelaje()
    {
        return $this->tonelaje;
    }

    /**
     * Set numeroEjes
     *
     * @param integer $numeroEjes
     *
     * @return VehiculoPesado
     */
    public function setNumeroEjes($numeroEjes)
    {
        $this->numeroEjes = $numeroEjes;

        return $this;
    }

    /**
     * Get numeroEjes
     *
     * @return integer
     */
    public function getNumeroEjes()
    {
        return $this->numeroEjes;
    }

    /**
     * Set numeroMt
     *
     * @param integer $numeroMt
     *
     * @return VehiculoPesado
     */
    public function setNumeroMt($numeroMt)
    {
        $this->numeroMt = $numeroMt;

        return $this;
    }

    /**
     * Get numeroMt
     *
     * @return integer
     */
    public function getNumeroMt()
    {
        return $this->numeroMt;
    }

    /**
     * Set fichaTecnicaHomologacionCarroceria
     *
     * @param string $fichaTecnicaHomologacionCarroceria
     *
     * @return VehiculoPesado
     */
    public function setFichaTecnicaHomologacionCarroceria($fichaTecnicaHomologacionCarroceria)
    {
        $this->fichaTecnicaHomologacionCarroceria = $fichaTecnicaHomologacionCarroceria;

        return $this;
    }

    /**
     * Get fichaTecnicaHomologacionCarroceria
     *
     * @return string
     */
    public function getFichaTecnicaHomologacionCarroceria()
    {
        return $this->fichaTecnicaHomologacionCarroceria;
    }

    /**
     * Set fichaTecnicaHomologacionChasis
     *
     * @param string $fichaTecnicaHomologacionChasis
     *
     * @return VehiculoPesado
     */
    public function setFichaTecnicaHomologacionChasis($fichaTecnicaHomologacionChasis)
    {
        $this->fichaTecnicaHomologacionChasis = $fichaTecnicaHomologacionChasis;

        return $this;
    }

    /**
     * Get fichaTecnicaHomologacionChasis
     *
     * @return string
     */
    public function getFichaTecnicaHomologacionChasis()
    {
        return $this->fichaTecnicaHomologacionChasis;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return VehiculoPesado
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
     * Set modalidad
     *
     * @param \AppBundle\Entity\Modalidad $modalidad
     *
     * @return VehiculoPesado
     */
    public function setModalidad(\AppBundle\Entity\Modalidad $modalidad = null)
    {
        $this->modalidad = $modalidad;

        return $this;
    }

    /**
     * Get modalidad
     *
     * @return \AppBundle\Entity\Modalidad
     */
    public function getModalidad()
    {
        return $this->modalidad;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return VehiculoPesado
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}