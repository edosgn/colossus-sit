<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvRevision
 *
 * @ORM\Table(name="sv_revision")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvRevisionRepository")
 */
class SvRevision
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
     * @ORM\Column(name="numero_radicado", type="string", length=10)
     */
    private $numeroRadicado;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo", type="integer", length=20)
     */
    private $consecutivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recepcion", type="date")
     */
    private $fechaRecepcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_revision", type="date")
     */
    private $fechaRevision;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_devolucion", type="date")
     */
    private $fechaDevolucion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_otorgamiento", type="date", nullable=true)
     */
    private $fechaOtorgamiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_visita_control_1", type="date", nullable=true)
     */
    private $fechaVisitaControl1;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion_visita_1", type="string", length=255, nullable=true)
     */
    private $observacionVisita1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_visita_control_2", type="date", nullable=true)
     */
    private $fechaVisitaControl2;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion_visita_2", type="string", length=255, nullable=true)
     */
    private $observacionVisita2;

    /**
     * @var string
     *
     * @ORM\Column(name="persona_contacto", type="string", length=255)
     */
    private $personaContacto;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=255)
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="revisiones")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario")
     **/
    protected $funcionario;

    /**
     * @ORM\OneToOne(targetEntity="SvEvaluacion")
     */
    private $evaluacion;
  
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

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
     * Set numeroRadicado
     *
     * @param string $numeroRadicado
     *
     * @return SvRevision
     */
    public function setNumeroRadicado($numeroRadicado)
    {
        $this->numeroRadicado = $numeroRadicado;

        return $this;
    }

    /**
     * Get numeroRadicado
     *
     * @return string
     */
    public function getNumeroRadicado()
    {
        return $this->numeroRadicado;
    }

    /**
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return SvRevision
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return SvRevision
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaRecepcion
     *
     * @param \DateTime $fechaRecepcion
     *
     * @return SvRevision
     */
    public function setFechaRecepcion($fechaRecepcion)
    {
        $this->fechaRecepcion = $fechaRecepcion;

        return $this;
    }

    /**
     * Get fechaRecepcion
     *
     * @return \DateTime
     */
    public function getFechaRecepcion()
    {
        return $this->fechaRecepcion;
    }

    /**
     * Set fechaRevision
     *
     * @param \DateTime $fechaRevision
     *
     * @return SvRevision
     */
    public function setFechaRevision($fechaRevision)
    {
        $this->fechaRevision = $fechaRevision;

        return $this;
    }

    /**
     * Get fechaRevision
     *
     * @return \DateTime
     */
    public function getFechaRevision()
    {
        return $this->fechaRevision;
    }

    /**
     * Set fechaDevolucion
     *
     * @param \DateTime $fechaDevolucion
     *
     * @return SvRevision
     */
    public function setFechaDevolucion($fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;

        return $this;
    }

    /**
     * Get fechaDevolucion
     *
     * @return \DateTime
     */
    public function getFechaDevolucion()
    {
        return $this->fechaDevolucion;
    }

    /**
     * Set fechaOtorgamiento
     *
     * @param \DateTime $fechaOtorgamiento
     *
     * @return SvRevision
     */
    public function setFechaOtorgamiento($fechaOtorgamiento)
    {
        $this->fechaOtorgamiento = $fechaOtorgamiento;

        return $this;
    }

    /**
     * Get fechaOtorgamiento
     *
     * @return \DateTime
     */
    public function getFechaOtorgamiento()
    {
        return $this->fechaOtorgamiento;
    }

    /**
     * Set fechaVisitaControl1
     *
     * @param \DateTime $fechaVisitaControl1
     *
     * @return SvRevision
     */
    public function setFechaVisitaControl1($fechaVisitaControl1)
    {
        $this->fechaVisitaControl1 = $fechaVisitaControl1;

        return $this;
    }

    /**
     * Get fechaVisitaControl1
     *
     * @return \DateTime
     */
    public function getFechaVisitaControl1()
    {
        return $this->fechaVisitaControl1;
    }

    /**
     * Set observacionVisita1
     *
     * @param string $observacionVisita1
     *
     * @return SvRevision
     */
    public function setObservacionVisita1($observacionVisita1)
    {
        $this->observacionVisita1 = $observacionVisita1;

        return $this;
    }

    /**
     * Get observacionVisita1
     *
     * @return string
     */
    public function getObservacionVisita1()
    {
        return $this->observacionVisita1;
    }

    /**
     * Set fechaVisitaControl2
     *
     * @param \DateTime $fechaVisitaControl2
     *
     * @return SvRevision
     */
    public function setFechaVisitaControl2($fechaVisitaControl2)
    {
        $this->fechaVisitaControl2 = $fechaVisitaControl2;

        return $this;
    }

    /**
     * Get fechaVisitaControl2
     *
     * @return \DateTime
     */
    public function getFechaVisitaControl2()
    {
        return $this->fechaVisitaControl2;
    }

    /**
     * Set observacionVisita2
     *
     * @param string $observacionVisita2
     *
     * @return SvRevision
     */
    public function setObservacionVisita2($observacionVisita2)
    {
        $this->observacionVisita2 = $observacionVisita2;

        return $this;
    }

    /**
     * Get observacionVisita2
     *
     * @return string
     */
    public function getObservacionVisita2()
    {
        return $this->observacionVisita2;
    }

    /**
     * Set personaContacto
     *
     * @param string $personaContacto
     *
     * @return SvRevision
     */
    public function setPersonaContacto($personaContacto)
    {
        $this->personaContacto = $personaContacto;

        return $this;
    }

    /**
     * Get personaContacto
     *
     * @return string
     */
    public function getPersonaContacto()
    {
        return $this->personaContacto;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return SvRevision
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return SvRevision
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvRevision
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
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return SvRevision
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return SvRevision
     */
    public function setFuncionario(\JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Set evaluacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvEvaluacion $evaluacion
     *
     * @return SvRevision
     */
    public function setEvaluacion(\JHWEB\SeguridadVialBundle\Entity\SvEvaluacion $evaluacion = null)
    {
        $this->evaluacion = $evaluacion;

        return $this;
    }

    /**
     * Get evaluacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvEvaluacion
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }
}
