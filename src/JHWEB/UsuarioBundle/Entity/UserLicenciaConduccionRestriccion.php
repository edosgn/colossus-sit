<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLicenciaConduccionRestriccion
 *
 * @ORM\Table(name="user_licencia_conduccion_restriccion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLicenciaConduccionRestriccionRepository")
 */
class UserLicenciaConduccionRestriccion
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
     * @ORM\Column(name="fechaCancelacion", type="datetime", nullable=true)
     */
    private $fechaCancelacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaResolucion", type="datetime", nullable=true)
     */
    private $fechaResolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoActo", type="string", length=255, nullable=true)
     */
    private $tipoActo;

    /**
     * @var string
     *
     * @ORM\Column(name="numResolucion", type="string", length=255)
     */
    private $numResolucion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="datetime", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="datetime", nullable=true)
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
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="horas_comunitarias", type="boolean")
     */
    private $horasComunitarias;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion", inversedBy="licenciasConduccion") */
    private $userLicenciaConduccion;




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
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * Set numResolucion
     *
     * @param string $numResolucion
     *
     * @return UserLicenciaConduccionRestriccion
     */
    public function setNumResolucion($numResolucion)
    {
        $this->numResolucion = $numResolucion;

        return $this;
    }

    /**
     * Get numResolucion
     *
     * @return string
     */
    public function getNumResolucion()
    {
        return $this->numResolucion;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * @return UserLicenciaConduccionRestriccion
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
     * Set userLicenciaConduccion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserLicenciaConduccion $userLicenciaConduccion
     *
     * @return UserLicenciaConduccionRestriccion
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
}
