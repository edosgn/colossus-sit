<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLicenciaConduccion
 *
 * @ORM\Table(name="user_licencia_conduccion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLicenciaConduccionRepository")
 */
class UserLicenciaConduccion
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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;
    
    /**
     * @var string
     *
     * @ORM\Column(name="restriccion", type="text", nullable = true)
     */
    private $restriccion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="licenciasConduccion")
     **/
    protected $organismoTransito;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria", inversedBy="licenciasConduccion") */
    private $categoria;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgClase", inversedBy="licenciasConduccion") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgServicio", inversedBy="licenciasConduccion") */
    private $servicio;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="licenciasConduccion") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgPais", inversedBy="licenciasConduccion") */
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
     * @return UserLicenciaConduccion
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
     * @return UserLicenciaConduccion
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
     * @return UserLicenciaConduccion
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
        if ($this->fechaExpedicion) {
            return $this->fechaExpedicion->format('Y-m-d');
        }
        return $this->fechaExpedicion;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return UserLicenciaConduccion
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
        if ($this->fechaVencimiento) {
            return $this->fechaVencimiento->format('Y-m-d');
        }
        return $this->fechaVencimiento;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return UserLicenciaConduccion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set restriccion
     *
     * @param string $restriccion
     *
     * @return UserLicenciaConduccion
     */
    public function setRestriccion($restriccion)
    {
        $this->restriccion = $restriccion;

        return $this;
    }

    /**
     * Get restriccion
     *
     * @return string
     */
    public function getRestriccion()
    {
        return $this->restriccion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserLicenciaConduccion
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return UserLicenciaConduccion
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }

    /**
     * Set categoria
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria $categoria
     *
     * @return UserLicenciaConduccion
     */
    public function setCategoria(\JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return UserLicenciaConduccion
     */
    public function setClase(\JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgClase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set servicio
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio
     *
     * @return UserLicenciaConduccion
     */
    public function setServicio(\JHWEB\VehiculoBundle\Entity\VhloCfgServicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgServicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return UserLicenciaConduccion
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set pais
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgPais $pais
     *
     * @return UserLicenciaConduccion
     */
    public function setPais(\JHWEB\ConfigBundle\Entity\CfgPais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgPais
     */
    public function getPais()
    {
        return $this->pais;
    }
}
