<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLcRestriccion
 *
 * @ORM\Table(name="user_lc_restriccion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLcRestriccionRepository")
 */
class UserLcRestriccion
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cancelacion", type="datetime", nullable=true)
     */
    private $fechaCancelacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_resolucion", type="datetime", nullable=true)
     */
    private $fechaResolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_acto", type="string", length=255, nullable=true)
     */
    private $tipoActo;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_resolucion", type="string", length=255)
     */
    private $numeroResolucion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=true)
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=50)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="horas_comunitarias", type="boolean", nullable=true)
     */
    private $horasComunitarias;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion", inversedBy="licenciasConduccion") */
    private $userLicenciaConduccion;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCdoComparendo", inversedBy="ciudadanos") */
    private $comparendo;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
    


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
     * Set fechaCancelacion
     *
     * @param \DateTime $fechaCancelacion
     *
     * @return UserLcRestriccion
     */
    public function setFechaCancelacion($fechaCancelacion)
    {
        $this->fechaCancelacion = $fechaCancelacion;

        return $this;
    }

    /**
     * Get fechaCancelacion
     *
     * @return \DateTime
     */
    public function getFechaCancelacion()
    {
        return $this->fechaCancelacion;
    }

    /**
     * Set fechaResolucion
     *
     * @param \DateTime $fechaResolucion
     *
     * @return UserLcRestriccion
     */
    public function setFechaResolucion($fechaResolucion)
    {
        $this->fechaResolucion = $fechaResolucion;

        return $this;
    }

    /**
     * Get fechaResolucion
     *
     * @return \DateTime
     */
    public function getFechaResolucion()
    {
        return $this->fechaResolucion;
    }

    /**
     * Set tipoActo
     *
     * @param string $tipoActo
     *
     * @return UserLcRestriccion
     */
    public function setTipoActo($tipoActo)
    {
        $this->tipoActo = $tipoActo;

        return $this;
    }

    /**
     * Get tipoActo
     *
     * @return string
     */
    public function getTipoActo()
    {
        return $this->tipoActo;
    }

    /**
     * Set numeroResolucion
     *
     * @param string $numeroResolucion
     *
     * @return UserLcRestriccion
     */
    public function setNumeroResolucion($numeroResolucion)
    {
        $this->numeroResolucion = $numeroResolucion;

        return $this;
    }

    /**
     * Get numeroResolucion
     *
     * @return string
     */
    public function getNumeroResolucion()
    {
        return $this->numeroResolucion;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return UserLcRestriccion
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return UserLcRestriccion
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UserLcRestriccion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return UserLcRestriccion
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
     * Set horasComunitarias
     *
     * @param boolean $horasComunitarias
     *
     * @return UserLcRestriccion
     */
    public function setHorasComunitarias($horasComunitarias)
    {
        $this->horasComunitarias = $horasComunitarias;

        return $this;
    }

    /**
     * Get horasComunitarias
     *
     * @return boolean
     */
    public function getHorasComunitarias()
    {
        return $this->horasComunitarias;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserLcRestriccion
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
     * Set userLicenciaConduccion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion $userLicenciaConduccion
     *
     * @return UserLcRestriccion
     */
    public function setUserLicenciaConduccion(\JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion $userLicenciaConduccion = null)
    {
        $this->userLicenciaConduccion = $userLicenciaConduccion;

        return $this;
    }

    /**
     * Get userLicenciaConduccion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion
     */
    public function getUserLicenciaConduccion()
    {
        return $this->userLicenciaConduccion;
    }

    /**
     * Set comparendo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo
     *
     * @return UserLcRestriccion
     */
    public function setComparendo(\JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }
}
