<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudadano
 *
 * @ORM\Table(name="ciudadano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadanoRepository")
 */
class Ciudadano
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
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion_documento", type="datetime", nullable=true)
     */
    private $fechaExpedicionDocumento;

     /**
     * @var string
     *
     * @ORM\Column(name="direccion_trabajo", type="string", length=255, nullable=true)
     */
    private $direccionTrabajo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="ciudadanos") */
    private $municipioNacimiento;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="ciudadanos") */
    private $municipioResidencia;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="ciudadanos") */
    private $genero;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo", inversedBy="ciudadanos") */
    private $grupoSanguineo;

    /**
     * @ORM\OneToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario")
     */
    private $usuario;
   
    /**
     * @var boolean
     *
     * @ORM\Column(name="enrolado", type="boolean", nullable=true)
     */
    private $enrolado;
    
    public function __toString()
    {
        return $this->getNombres();
    }   

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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ciudadano
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set fechaExpedicionDocumento
     *
     * @param \DateTime $fechaExpedicionDocumento
     *
     * @return Ciudadano
     */
    public function setFechaExpedicionDocumento($fechaExpedicionDocumento)
    {
        $this->fechaExpedicionDocumento = $fechaExpedicionDocumento;

        return $this;
    }

    /**
     * Get fechaExpedicionDocumento
     *
     * @return \DateTime
     */
    public function getFechaExpedicionDocumento()
    {
        if ($this->fechaExpedicionDocumento) {
            return $this->fechaExpedicionDocumento->format('Y-m-d');
        }
        return $this->fechaExpedicionDocumento;
    }

    /**
     * Set direccionTrabajo
     *
     * @param string $direccionTrabajo
     *
     * @return Ciudadano
     */
    public function setDireccionTrabajo($direccionTrabajo)
    {
        $this->direccionTrabajo = $direccionTrabajo;

        return $this;
    }

    /**
     * Get direccionTrabajo
     *
     * @return string
     */
    public function getDireccionTrabajo()
    {
        return $this->direccionTrabajo;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Ciudadano
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
     * Set municipioNacimiento
     *
     * @param \AppBundle\Entity\Municipio $municipioNacimiento
     *
     * @return Ciudadano
     */
    public function setMunicipioNacimiento(\AppBundle\Entity\Municipio $municipioNacimiento = null)
    {
        $this->municipioNacimiento = $municipioNacimiento;

        return $this;
    }

    /**
     * Get municipioNacimiento
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioNacimiento()
    {
        return $this->municipioNacimiento;
    }

    /**
     * Set municipioResidencia
     *
     * @param \AppBundle\Entity\Municipio $municipioResidencia
     *
     * @return Ciudadano
     */
    public function setMunicipioResidencia(\AppBundle\Entity\Municipio $municipioResidencia = null)
    {
        $this->municipioResidencia = $municipioResidencia;

        return $this;
    }

    /**
     * Get municipioResidencia
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioResidencia()
    {
        return $this->municipioResidencia;
    }

    /**
     * Set genero
     *
     * @param \AppBundle\Entity\Genero $genero
     *
     * @return Ciudadano
     */
    public function setGenero(\AppBundle\Entity\Genero $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \AppBundle\Entity\Genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set grupoSanguineo
     *
     * @param \AppBundle\Entity\GrupoSanguineo $grupoSanguineo
     *
     * @return Ciudadano
     */
    public function setGrupoSanguineo(\AppBundle\Entity\GrupoSanguineo $grupoSanguineo = null)
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

    /**
     * Get grupoSanguineo
     *
     * @return \AppBundle\Entity\GrupoSanguineo
     */
    public function getGrupoSanguineo()
    {
        return $this->grupoSanguineo;
    }

    /**
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return Ciudadano
     */
    public function setUsuario(\Repository\UsuarioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Repository\UsuarioBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set enrolado
     *
     * @param boolean $enrolado
     *
     * @return Ciudadano
     */
    public function setEnrolado($enrolado)
    {
        $this->enrolado = $enrolado;

        return $this;
    }

    /**
     * Get enrolado
     *
     * @return boolean
     */
    public function getEnrolado()
    {
        return $this->enrolado;
    }
}
