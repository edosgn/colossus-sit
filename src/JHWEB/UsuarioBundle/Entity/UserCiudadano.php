<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCiudadano
 *
 * @ORM\Table(name="user_ciudadano")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserCiudadanoRepository")
 */
class UserCiudadano
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
     * @ORM\Column(name="primer_nombre", type="string", length=255)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=255, nullable=true)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=255)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=255, nullable=true)
     */
    private $segundoApellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="identificacion", type="integer", nullable=false)
     */
    private $identificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion_documento", type="date", nullable=true)
     */
    private $fechaExpedicionDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_personal", type="string", length=255)
     */
    private $direccionPersonal;

     /**
     * @var string
     *
     * @ORM\Column(name="direccion_trabajo", type="string", length=255, nullable=true)
     */
    private $direccionTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_celular", type="string", length=50, nullable=true)
     */
    private $telefonoCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_fijo", type="string", length=50, nullable=true)
     */
    private $telefonoFijo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enrolado", type="boolean", nullable=true)
     */
    private $enrolado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="ciudadanos") */
    private $municipioNacimiento;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="ciudadanos") */
    private $municipioResidencia;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="ciudadanos") */
    private $genero;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo", inversedBy="ciudadanos") */
    private $grupoSanguineo;

    /** @ORM\ManyToOne(targetEntity="UserCfgTipoIdentificacion", inversedBy="ciudadanos") */
    private $tipoIdentificacion;

    /**
     * @ORM\OneToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario")
     */
    private $usuario;


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
     * Set primerNombre
     *
     * @param string $primerNombre
     *
     * @return UserCiudadano
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;

        return $this;
    }

    /**
     * Get primerNombre
     *
     * @return string
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     *
     * @return UserCiudadano
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundoNombre
     *
     * @return string
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return UserCiudadano
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return UserCiudadano
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set identificacion
     *
     * @param integer $identificacion
     *
     * @return UserCiudadano
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return integer
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return UserCiudadano
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        if ($this->fechaNacimiento) {
            return $this->fechaNacimiento->format('Y-m-d');
        }
        return $this->fechaNacimiento;
    }

    /**
     * Set fechaExpedicionDocumento
     *
     * @param \DateTime $fechaExpedicionDocumento
     *
     * @return UserCiudadano
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
     * Set direccionPersonal
     *
     * @param string $direccionPersonal
     *
     * @return UserCiudadano
     */
    public function setDireccionPersonal($direccionPersonal)
    {
        $this->direccionPersonal = $direccionPersonal;

        return $this;
    }

    /**
     * Get direccionPersonal
     *
     * @return string
     */
    public function getDireccionPersonal()
    {
        return $this->direccionPersonal;
    }

    /**
     * Set direccionTrabajo
     *
     * @param string $direccionTrabajo
     *
     * @return UserCiudadano
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
     * Set telefonoCelular
     *
     * @param string $telefonoCelular
     *
     * @return UserCiudadano
     */
    public function setTelefonoCelular($telefonoCelular)
    {
        $this->telefonoCelular = $telefonoCelular;

        return $this;
    }

    /**
     * Get telefonoCelular
     *
     * @return string
     */
    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    /**
     * Set telefonoFijo
     *
     * @param string $telefonoFijo
     *
     * @return UserCiudadano
     */
    public function setTelefonoFijo($telefonoFijo)
    {
        $this->telefonoFijo = $telefonoFijo;

        return $this;
    }

    /**
     * Get telefonoFijo
     *
     * @return string
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    /**
     * Set enrolado
     *
     * @param boolean $enrolado
     *
     * @return UserCiudadano
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

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserCiudadano
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
     * Set municipioNacimiento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioNacimiento
     *
     * @return UserCiudadano
     */
    public function setMunicipioNacimiento(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioNacimiento = null)
    {
        $this->municipioNacimiento = $municipioNacimiento;

        return $this;
    }

    /**
     * Get municipioNacimiento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipioNacimiento()
    {
        return $this->municipioNacimiento;
    }

    /**
     * Set municipioResidencia
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioResidencia
     *
     * @return UserCiudadano
     */
    public function setMunicipioResidencia(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioResidencia = null)
    {
        $this->municipioResidencia = $municipioResidencia;

        return $this;
    }

    /**
     * Get municipioResidencia
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipioResidencia()
    {
        return $this->municipioResidencia;
    }

    /**
     * Set genero
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGenero $genero
     *
     * @return UserCiudadano
     */
    public function setGenero(\JHWEB\UsuarioBundle\Entity\UserCfgGenero $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgGenero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set grupoSanguineo
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo $grupoSanguineo
     *
     * @return UserCiudadano
     */
    public function setGrupoSanguineo(\JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo $grupoSanguineo = null)
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

    /**
     * Get grupoSanguineo
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo
     */
    public function getGrupoSanguineo()
    {
        return $this->grupoSanguineo;
    }

    /**
     * Set tipoIdentificacion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacion
     *
     * @return UserCiudadano
     */
    public function setTipoIdentificacion(\JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacion = null)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
    }

    /**
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return UserCiudadano
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
}
