<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Peticionario
 *
 * @ORM\Table(name="peticionario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeticionarioRepository")
 */
class Peticionario
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
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroRadicado", type="string", length=10)
     */
    private $numeroRadicado;

    /**
     * @var int
     *
     * @ORM\Column(name="folios", type="integer")
     */
    private $folios;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroOficio", type="string", length=45)
     */
    private $numeroOficio;

    /**
     * @var string
     *
     * @ORM\Column(name="primerNombre", type="string", length=100)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoNombre", type="string", length=100)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=100)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=100)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion", type="string", length=20)
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEntidad", type="string", length=255)
     */
    private $nombreEntidad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=100)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=20)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correoElectronico", type="string", length=100)
     */
    private $correoElectronico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaVencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="urlDocumento", type="string", length=255, nullable=true)
     */
    private $urlDocumento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="correCertificado", type="boolean")
     */
    private $correCertificado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreTransportadora", type="string", length=255, nullable=true)
     */
    private $nombreTransportadora;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEnvio", type="date", nullable=true)
     */
    private $fechaEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGuia", type="string", length=20, nullable=true)
     */
    private $numeroGuia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaSalida", type="datetime")
     */
    private $fechaSalida;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario") */
    private $usuario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="peticionarios") */
    private $tipoIdentificacion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoDocumento", inversedBy="peticionarios") */
    protected $tipoDocumento;

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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Peticionario
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
     * Set numeroRadicado
     *
     * @param string $numeroRadicado
     *
     * @return Peticionario
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
     * Set folios
     *
     * @param integer $folios
     *
     * @return Peticionario
     */
    public function setFolios($folios)
    {
        $this->folios = $folios;

        return $this;
    }

    /**
     * Get folios
     *
     * @return integer
     */
    public function getFolios()
    {
        return $this->folios;
    }

    /**
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return Peticionario
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return string
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     *
     * @return Peticionario
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
     * @return Peticionario
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
     * @return Peticionario
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
     * @return Peticionario
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
     * @param string $identificacion
     *
     * @return Peticionario
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return string
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set nombreEntidad
     *
     * @param string $nombreEntidad
     *
     * @return Peticionario
     */
    public function setNombreEntidad($nombreEntidad)
    {
        $this->nombreEntidad = $nombreEntidad;

        return $this;
    }

    /**
     * Get nombreEntidad
     *
     * @return string
     */
    public function getNombreEntidad()
    {
        return $this->nombreEntidad;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Peticionario
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
     * @return Peticionario
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
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Peticionario
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return Peticionario
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Peticionario
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set urlDocumento
     *
     * @param string $urlDocumento
     *
     * @return Peticionario
     */
    public function setUrlDocumento($urlDocumento)
    {
        $this->urlDocumento = $urlDocumento;

        return $this;
    }

    /**
     * Get urlDocumento
     *
     * @return string
     */
    public function getUrlDocumento()
    {
        return $this->urlDocumento;
    }

    /**
     * Set correCertificado
     *
     * @param boolean $correCertificado
     *
     * @return Peticionario
     */
    public function setCorreCertificado($correCertificado)
    {
        $this->correCertificado = $correCertificado;

        return $this;
    }

    /**
     * Get correCertificado
     *
     * @return boolean
     */
    public function getCorreCertificado()
    {
        return $this->correCertificado;
    }

    /**
     * Set nombreTransportadora
     *
     * @param string $nombreTransportadora
     *
     * @return Peticionario
     */
    public function setNombreTransportadora($nombreTransportadora)
    {
        $this->nombreTransportadora = $nombreTransportadora;

        return $this;
    }

    /**
     * Get nombreTransportadora
     *
     * @return string
     */
    public function getNombreTransportadora()
    {
        return $this->nombreTransportadora;
    }

    /**
     * Set fechaEnvio
     *
     * @param \DateTime $fechaEnvio
     *
     * @return Peticionario
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    /**
     * Get fechaEnvio
     *
     * @return \DateTime
     */
    public function getFechaEnvio()
    {
        return $this->fechaEnvio;
    }

    /**
     * Set numeroGuia
     *
     * @param string $numeroGuia
     *
     * @return Peticionario
     */
    public function setNumeroGuia($numeroGuia)
    {
        $this->numeroGuia = $numeroGuia;

        return $this;
    }

    /**
     * Get numeroGuia
     *
     * @return string
     */
    public function getNumeroGuia()
    {
        return $this->numeroGuia;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return Peticionario
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Peticionario
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
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return Peticionario
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
     * Set tipoIdentificacion
     *
     * @param \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion
     *
     * @return Peticionario
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
     * Set tipoDocumento
     *
     * @param \AppBundle\Entity\TipoDocumento $tipoDocumento
     *
     * @return Peticionario
     */
    public function setTipoDocumento(\AppBundle\Entity\TipoDocumento $tipoDocumento = null)
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    /**
     * Get tipoDocumento
     *
     * @return \AppBundle\Entity\TipoDocumento
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }
}
