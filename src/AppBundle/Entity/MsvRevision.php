<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvRevision
 *
 * @ORM\Table(name="msv_revision")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvRevisionRepository")
 */
class MsvRevision
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
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="revisiones")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario")
     **/
    protected $funcionario;

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
     * Set fechaRecepcion
     *
     * @param \DateTime $fechaRecepcion
     *
     * @return MsvRevision
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
        if ($this->fechaRecepcion) {
            return $this->fechaRecepcion->format('d/m/Y');
        }
    }

    /**
     * Set fechaRevision
     *
     * @param \DateTime $fechaRevision
     *
     * @return MsvRevision
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
        if ($this->fechaRevision) {
            return $this->fechaRevision->format('d/m/Y');
        }
    }

    /**
     * Set fechaDevolucion
     *
     * @param \DateTime $fechaDevolucion
     *
     * @return MsvRevision
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
        if ($this->fechaDevolucion) {
            return $this->fechaDevolucion->format('d/m/Y');
        }
    }

    /**
     * Set fechaOtorgamiento
     *
     * @param \DateTime $fechaOtorgamiento
     *
     * @return MsvRevision
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
        if ($this->fechaOtorgamiento) {
            return $this->fechaOtorgamiento->format('d/m/Y');
        }
    }

    /**
     * Set fechaVisitaControl1
     *
     * @param \DateTime $fechaVisitaControl1
     *
     * @return MsvRevision
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
        if ($this->fechaVisitaControl1) {
            return $this->fechaVisitaControl1->format('d/m/Y');
        }
    }

    /**
     * Set observacionVisita1
     *
     * @param string $observacionVisita1
     *
     * @return MsvRevision
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
     * @return MsvRevision
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
        if ($this->fechaVisitaControl2) {
            return $this->fechaVisitaControl2->format('d/m/Y');
        }
    }

    /**
     * Set observacionVisita2
     *
     * @param string $observacionVisita2
     *
     * @return MsvRevision
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
     * @return MsvRevision
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
     * @return MsvRevision
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
     * @return MsvRevision
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MsvRevision
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return MsvRevision
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
     * @param \AppBundle\Entity\MpersonalFuncionario $funcionario
     *
     * @return MsvRevision
     */
    public function setFuncionario(\AppBundle\Entity\MpersonalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \AppBundle\Entity\MpersonalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
