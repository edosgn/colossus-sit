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
     * @ORM\Column(name="fecha_devolucion", type="date")
     */
    private $fechaDevolucion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_otorgamiento", type="date")
     */
    private $fechaOtorgamiento;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
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
        return $this->fechaRecepcion->format('d/m/Y');
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
        return $this->fechaDevolucion->format('d/m/Y');
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
        return $this->fechaOtorgamiento->format('d/m/Y');
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
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return MsvRevision
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
