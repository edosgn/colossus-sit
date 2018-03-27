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
     * @var int
     *
     * @ORM\Column(name="numero_identificacion", type="integer")
     */
    private $numeroIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_nombre", type="string", length=255)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=255)
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
     * @ORM\Column(name="segundo_apellido", type="string", length=255)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion_documento", type="datetime")
     */
    private $fechaExpedicionDocumento;

     /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=255)
     */
    private $genero;

     /**
     * @var string
     *
     * @ORM\Column(name="grupo_sanguineo", type="string", length=255)
     */
    private $grupoSanguineo;


     /**
     * @var string
     *
     * @ORM\Column(name="direccion_trabajo", type="string", length=255)
     */
    private $direccionTrabajo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="ciudadanos") */
    private $tipoIdentificacion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="ciudadanos") */
    private $municipioNacimiento;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="ciudadanos") */
    private $municipioResidencia;

   

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
     * Set numeroIdentificacion
     *
     * @param integer $numeroIdentificacion
     *
     * @return Ciudadano
     */
    public function setNumeroIdentificacion($numeroIdentificacion)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;

        return $this;
    }

    /**
     * Get numeroIdentificacion
     *
     * @return integer
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     *
     * @return Ciudadano
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
     * @return Ciudadano
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
     * @return Ciudadano
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
     * @return Ciudadano
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Ciudadano
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Ciudadano
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
     * Set tipoIdentificacion
     *
     * @param \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion
     *
     * @return Ciudadano
     */
    public function setTipoIdentificacion(\AppBundle\Entity\TipoIdentificacion $tipoIdentificacion = null)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return \AppBundle\Entity\TipoIdentificacion
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
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
        return $this->fechaExpedicionDocumento->format('Y-m-d');
    }

    /**
     * Set edad
     *
     * @param integer $edad
     *
     * @return Ciudadano
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set genero
     *
     * @param string $genero
     *
     * @return Ciudadano
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set grupoSanguineo
     *
     * @param string $grupoSanguineo
     *
     * @return Ciudadano
     */
    public function setGrupoSanguineo($grupoSanguineo)
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

    /**
     * Get grupoSanguineo
     *
     * @return string
     */
    public function getGrupoSanguineo()
    {
        return $this->grupoSanguineo;
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
}
