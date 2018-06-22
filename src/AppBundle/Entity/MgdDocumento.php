<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MgdDocumento
 *
 * @ORM\Table(name="mgd_documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MgdDocumentoRepository")
 */
class MgdDocumento
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
     * @ORM\Column(name="numeroOficio", type="string", length=50)
     */
    private $numeroOficio;

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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="correoCertificadoLlegada", type="boolean", nullable=true)
     */
    private $correoCertificadoLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreTransportadoraLlegada", type="string", length=255, nullable=true)
     */
    private $nombreTransportadoraLlegada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaLlegada", type="datetime", nullable=true)
     */
    private $fechaLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGuiaLlegada", type="string", length=20, nullable=true)
     */
    private $numeroGuiaLlegada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="correoCertificadoEnvio", type="boolean", nullable=true)
     */
    private $correoCertificadoEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreTransportadoraEnvio", type="string", length=255, nullable=true)
     */
    private $nombreTransportadoraEnvio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEnvio", type="datetime", nullable=true)
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
     * @ORM\Column(name="fechaSalida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="asignado", type="boolean")
     */
    private $asignado = false;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MgdTipoCorrespondencia", inversedBy="documentos")
     **/
    protected $tipoCorrespondencia;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="documentos")
     **/
    protected $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario", inversedBy="documentos") */
    protected $usuario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\MgdPeticionario", inversedBy="documentos") */
    protected $peticionario;


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
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * Set url
     *
     * @param string $url
     *
     * @return MgdDocumento
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set correoCertificadoLlegada
     *
     * @param boolean $correoCertificadoLlegada
     *
     * @return MgdDocumento
     */
    public function setCorreoCertificadoLlegada($correoCertificadoLlegada)
    {
        $this->correoCertificadoLlegada = $correoCertificadoLlegada;

        return $this;
    }

    /**
     * Get correoCertificadoLlegada
     *
     * @return boolean
     */
    public function getCorreoCertificadoLlegada()
    {
        return $this->correoCertificadoLlegada;
    }

    /**
     * Set nombreTransportadoraLlegada
     *
     * @param string $nombreTransportadoraLlegada
     *
     * @return MgdDocumento
     */
    public function setNombreTransportadoraLlegada($nombreTransportadoraLlegada)
    {
        $this->nombreTransportadoraLlegada = $nombreTransportadoraLlegada;

        return $this;
    }

    /**
     * Get nombreTransportadoraLlegada
     *
     * @return string
     */
    public function getNombreTransportadoraLlegada()
    {
        return $this->nombreTransportadoraLlegada;
    }

    /**
     * Set fechaLlegada
     *
     * @param \DateTime $fechaLlegada
     *
     * @return MgdDocumento
     */
    public function setFechaLlegada($fechaLlegada)
    {
        $this->fechaLlegada = $fechaLlegada;

        return $this;
    }

    /**
     * Get fechaLlegada
     *
     * @return \DateTime
     */
    public function getFechaLlegada()
    {
        return $this->fechaLlegada;
    }

    /**
     * Set numeroGuiaLlegada
     *
     * @param string $numeroGuiaLlegada
     *
     * @return MgdDocumento
     */
    public function setNumeroGuiaLlegada($numeroGuiaLlegada)
    {
        $this->numeroGuiaLlegada = $numeroGuiaLlegada;

        return $this;
    }

    /**
     * Get numeroGuiaLlegada
     *
     * @return string
     */
    public function getNumeroGuiaLlegada()
    {
        return $this->numeroGuiaLlegada;
    }

    /**
     * Set correoCertificadoEnvio
     *
     * @param boolean $correoCertificadoEnvio
     *
     * @return MgdDocumento
     */
    public function setCorreoCertificadoEnvio($correoCertificadoEnvio)
    {
        $this->correoCertificadoEnvio = $correoCertificadoEnvio;

        return $this;
    }

    /**
     * Get correoCertificadoEnvio
     *
     * @return boolean
     */
    public function getCorreoCertificadoEnvio()
    {
        return $this->correoCertificadoEnvio;
    }

    /**
     * Set nombreTransportadoraEnvio
     *
     * @param string $nombreTransportadoraEnvio
     *
     * @return MgdDocumento
     */
    public function setNombreTransportadoraEnvio($nombreTransportadoraEnvio)
    {
        $this->nombreTransportadoraEnvio = $nombreTransportadoraEnvio;

        return $this;
    }

    /**
     * Get nombreTransportadoraEnvio
     *
     * @return string
     */
    public function getNombreTransportadoraEnvio()
    {
        return $this->nombreTransportadoraEnvio;
    }

    /**
     * Set fechaEnvio
     *
     * @param \DateTime $fechaEnvio
     *
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * @return MgdDocumento
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MgdDocumento
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
     * Set asignado
     *
     * @param boolean $asignado
     *
     * @return MgdDocumento
     */
    public function setAsignado($asignado)
    {
        $this->asignado = $asignado;

        return $this;
    }

    /**
     * Get asignado
     *
     * @return boolean
     */
    public function getAsignado()
    {
        return $this->asignado;
    }

    /**
     * Set tipoCorrespondencia
     *
     * @param \AppBundle\Entity\MgdTipoCorrespondencia $tipoCorrespondencia
     *
     * @return MgdDocumento
     */
    public function setTipoCorrespondencia(\AppBundle\Entity\MgdTipoCorrespondencia $tipoCorrespondencia = null)
    {
        $this->tipoCorrespondencia = $tipoCorrespondencia;

        return $this;
    }

    /**
     * Get tipoCorrespondencia
     *
     * @return \AppBundle\Entity\MgdTipoCorrespondencia
     */
    public function getTipoCorrespondencia()
    {
        return $this->tipoCorrespondencia;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return MgdDocumento
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return MgdDocumento
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
     * Set peticionario
     *
     * @param \AppBundle\Entity\MgdPeticionario $peticionario
     *
     * @return MgdDocumento
     */
    public function setPeticionario(\AppBundle\Entity\MgdPeticionario $peticionario = null)
    {
        $this->peticionario = $peticionario;

        return $this;
    }

    /**
     * Get peticionario
     *
     * @return \AppBundle\Entity\MgdPeticionario
     */
    public function getPeticionario()
    {
        return $this->peticionario;
    }
}
