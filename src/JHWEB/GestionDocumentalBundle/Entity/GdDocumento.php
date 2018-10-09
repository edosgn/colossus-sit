<?php

namespace JHWEB\GestionDocumentalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GdDocumento
 *
 * @ORM\Table(name="gd_documento")
 * @ORM\Entity(repositoryClass="JHWEB\GestionDocumentalBundle\Repository\GdDocumentoRepository")
 */
class GdDocumento
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
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo;

    /**
     * @var int
     *
     * @ORM\Column(name="folios", type="integer")
     */
    private $folios;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroOficio", type="string", length=50, nullable=true)
     */
    private $numeroOficio;

    /**
     * @var int
     *
     * @ORM\Column(name="diasVigencia", type="integer", nullable=true)
     */
    private $diasVigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaVencimiento", type="date", nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
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
    private $correoCertificadoLlegada = false;

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
     * @ORM\Column(name="medioEnvio", type="string", length=255, nullable=true)
     */
    private $medioEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGuia", type="string", length=20, nullable=true)
     */
    private $numeroGuia;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroCarpeta", type="string", length=10, nullable=true)
     */
    private $numeroCarpeta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @var string
     *
     * @ORM\Column(name="entidadNombre", type="text", nullable=true)
     */
    private $entidadNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="entidadCargo", type="text", nullable=true)
     */
    private $entidadCargo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="documentos")
     **/
    protected $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="documentos") */
    protected $peticionario;

    /**
     * @ORM\ManyToOne(targetEntity="GdCfgTipoCorrespondencia", inversedBy="documentos")
     **/
    protected $tipoCorrespondencia;

    /** @ORM\ManyToOne(targetEntity="GdRemitente", inversedBy="documentos") */
    protected $remitente;


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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * Set folios
     *
     * @param integer $folios
     *
     * @return GdDocumento
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
     * @return GdDocumento
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
     * Set diasVigencia
     *
     * @param integer $diasVigencia
     *
     * @return GdDocumento
     */
    public function setDiasVigencia($diasVigencia)
    {
        $this->diasVigencia = $diasVigencia;

        return $this;
    }

    /**
     * Get diasVigencia
     *
     * @return integer
     */
    public function getDiasVigencia()
    {
        return $this->diasVigencia;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * Set medioEnvio
     *
     * @param string $medioEnvio
     *
     * @return GdDocumento
     */
    public function setMedioEnvio($medioEnvio)
    {
        $this->medioEnvio = $medioEnvio;

        return $this;
    }

    /**
     * Get medioEnvio
     *
     * @return string
     */
    public function getMedioEnvio()
    {
        return $this->medioEnvio;
    }

    /**
     * Set numeroGuia
     *
     * @param string $numeroGuia
     *
     * @return GdDocumento
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
     * Set numeroCarpeta
     *
     * @param string $numeroCarpeta
     *
     * @return GdDocumento
     */
    public function setNumeroCarpeta($numeroCarpeta)
    {
        $this->numeroCarpeta = $numeroCarpeta;

        return $this;
    }

    /**
     * Get numeroCarpeta
     *
     * @return string
     */
    public function getNumeroCarpeta()
    {
        return $this->numeroCarpeta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return GdDocumento
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
     * Set entidadNombre
     *
     * @param string $entidadNombre
     *
     * @return GdDocumento
     */
    public function setEntidadNombre($entidadNombre)
    {
        $this->entidadNombre = $entidadNombre;

        return $this;
    }

    /**
     * Get entidadNombre
     *
     * @return string
     */
    public function getEntidadNombre()
    {
        return $this->entidadNombre;
    }

    /**
     * Set entidadCargo
     *
     * @param string $entidadCargo
     *
     * @return GdDocumento
     */
    public function setEntidadCargo($entidadCargo)
    {
        $this->entidadCargo = $entidadCargo;

        return $this;
    }

    /**
     * Get entidadCargo
     *
     * @return string
     */
    public function getEntidadCargo()
    {
        return $this->entidadCargo;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return GdDocumento
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
     * Set peticionario
     *
     * @param \AppBundle\Entity\Ciudadano $peticionario
     *
     * @return GdDocumento
     */
    public function setPeticionario(\AppBundle\Entity\Ciudadano $peticionario = null)
    {
        $this->peticionario = $peticionario;

        return $this;
    }

    /**
     * Get peticionario
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getPeticionario()
    {
        return $this->peticionario;
    }

    /**
     * Set tipoCorrespondencia
     *
     * @param \JHWEB\GestionDocumentalBundle\Entity\GdCfgTipoCorrespondencia $tipoCorrespondencia
     *
     * @return GdDocumento
     */
    public function setTipoCorrespondencia(\JHWEB\GestionDocumentalBundle\Entity\GdCfgTipoCorrespondencia $tipoCorrespondencia = null)
    {
        $this->tipoCorrespondencia = $tipoCorrespondencia;

        return $this;
    }

    /**
     * Get tipoCorrespondencia
     *
     * @return \JHWEB\GestionDocumentalBundle\Entity\GdCfgTipoCorrespondencia
     */
    public function getTipoCorrespondencia()
    {
        return $this->tipoCorrespondencia;
    }

    /**
     * Set remitente
     *
     * @param \JHWEB\GestionDocumentalBundle\Entity\GdRemitente $remitente
     *
     * @return GdDocumento
     */
    public function setRemitente(\JHWEB\GestionDocumentalBundle\Entity\GdRemitente $remitente = null)
    {
        $this->remitente = $remitente;

        return $this;
    }

    /**
     * Get remitente
     *
     * @return \JHWEB\GestionDocumentalBundle\Entity\GdRemitente
     */
    public function getRemitente()
    {
        return $this->remitente;
    }
}
