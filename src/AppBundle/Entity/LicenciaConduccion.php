<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LicenciaConduccion
 *
 * @ORM\Table(name="licencia_conduccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LicenciaConduccionRepository")
 */
class LicenciaConduccion
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
     * @ORM\Column(name="numero", type="bigint")
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroRunt", type="bigint")
     */
    private $numeroRunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="licenciasConduccion") */
    private $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgLicenciaConduccionCategoria", inversedBy="licenciasConduccion") */
    private $categoria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="licenciasConduccion") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="licenciasConduccion") */
    private $servicio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramiteFactura", inversedBy="licenciasConduccion") */
    private $tramiteFactura;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="licenciasConduccion") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pais", inversedBy="licenciasConduccion") */
    private $pais;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return LicenciaConduccion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set numeroRunt
     *
     * @param integer $numeroRunt
     *
     * @return LicenciaConduccion
     */
    public function setNumeroRunt($numeroRunt)
    {
        $this->numeroRunt = $numeroRunt;

        return $this;
    }

    /**
     * Get numeroRunt
     *
     * @return integer
     */
    public function getNumeroRunt()
    {
        return $this->numeroRunt;
    }

    /**
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return LicenciaConduccion
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return \DateTime
     */
    public function getFechaExpedicion()
    {
        return $this->fechaExpedicion;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return LicenciaConduccion
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return LicenciaConduccion
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
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return LicenciaConduccion
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\CfgLicenciaConduccionCategoria $categoria
     *
     * @return LicenciaConduccion
     */
    public function setCategoria(\AppBundle\Entity\CfgLicenciaConduccionCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\CfgLicenciaConduccionCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return LicenciaConduccion
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
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return LicenciaConduccion
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set tramiteFactura
     *
     * @param \AppBundle\Entity\TramiteFactura $tramiteFactura
     *
     * @return LicenciaConduccion
     */
    public function setTramiteFactura(\AppBundle\Entity\TramiteFactura $tramiteFactura = null)
    {
        $this->tramiteFactura = $tramiteFactura;

        return $this;
    }

    /**
     * Get tramiteFactura
     *
     * @return \AppBundle\Entity\TramiteFactura
     */
    public function getTramiteFactura()
    {
        return $this->tramiteFactura;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return LicenciaConduccion
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set pais
     *
     * @param \AppBundle\Entity\Pais $pais
     *
     * @return LicenciaConduccion
     */
    public function setPais(\AppBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }
}
