<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvRestriccion
 *
 * @ORM\Table(name="cv_restriccion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvRestriccionRepository")
 */
class CvRestriccion
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
     * @ORM\Column(name="id_foranea", type="string", length=5)
     */
    private $idForanea;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

 
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="notificaciones") */
    private $vehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion", type="string", length=255)
     */
    private $identificacion;

    
    /** @ORM\ManyToOne(targetEntity="CvCfgTipoRestriccion", inversedBy="notificaciones") */
    private $tipoRestriccion;


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
     * Set idForanea
     *
     * @param string $idForanea
     *
     * @return CvRestriccion
     */
    public function setIdForanea($idForanea)
    {
        $this->idForanea = $idForanea;

        return $this;
    }

    /**
     * Get idForanea
     *
     * @return string
     */
    public function getIdForanea()
    {
        return $this->idForanea;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CvRestriccion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return CvRestriccion
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return CvRestriccion
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set identificacion
     *
     * @param string $identificacion
     *
     * @return CvRestriccion
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return string
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return CvRestriccion
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
     * Set tipoRestriccion
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion $tipoRestriccion
     *
     * @return CvRestriccion
     */
    public function setTipoRestriccion(\JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion $tipoRestriccion = null)
    {
        $this->tipoRestriccion = $tipoRestriccion;

        return $this;
    }

    /**
     * Get tipoRestriccion
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion
     */
    public function getTipoRestriccion()
    {
        return $this->tipoRestriccion;
    }
}
