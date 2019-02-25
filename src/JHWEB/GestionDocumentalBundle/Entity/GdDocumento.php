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
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_radicado", type="string", length=10)
     */
    private $numeroRadicado;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_salida", type="string", length=50, nullable=true)
     */
    private $numeroSalida;

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
     * @ORM\Column(name="numero_oficio", type="string", length=50, nullable=true)
     */
    private $numeroOficio;

    /**
     * @var int
     *
     * @ORM\Column(name="dias_vigencia", type="integer", nullable=true)
     */
    private $diasVigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date", nullable=true)
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
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_llegada", type="datetime", nullable=true)
     */
    private $fechaLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle_llegada", type="text", nullable=true)
     */
    private $detalleLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle_envio", type="text", nullable=true)
     */
    private $detalleEnvio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_envio", type="datetime", nullable=true)
     */
    private $fechaEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_carpeta", type="string", length=10, nullable=true)
     */
    private $numeroCarpeta;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=50, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="peticionario_nombres", type="string", length=255, nullable=true)
     */
    private $peticionarioNombres;

    /**
     * @var string
     *
     * @ORM\Column(name="peticionario_apellidos", type="string", length=255, nullable=true)
     */
    private $peticionarioApellidos;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion", type="bigint", nullable=true)
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="entidad_nombre", type="string", length=255, nullable=true)
     */
    private $entidadNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="entidad_cargo", type="string", length=255, nullable=true)
     */
    private $entidadCargo;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=100, nullable=true)
     */
    private $correo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="documentos") */
    private $tipoIdentificacion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="documentos") */
    private $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="documentos")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="GdCfgTipoCorrespondencia", inversedBy="documentos")
     **/
    protected $tipoCorrespondencia;

    /**
     * @ORM\ManyToOne(targetEntity="GdCfgMedioCorrespondencia", inversedBy="documentos")
     **/
    protected $medioCorrespondenciaLlegada;

    /**
     * @ORM\ManyToOne(targetEntity="GdCfgMedioCorrespondencia", inversedBy="documentos")
     **/
    protected $medioCorrespondenciaEnvio;


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
        if ($this->fechaRegistro) {
            return $this->fechaRegistro->format('d/m/Y');
        }
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
     * Set numeroSalida
     *
     * @param string $numeroSalida
     *
     * @return GdDocumento
     */
    public function setNumeroSalida($numeroSalida)
    {
        $this->numeroSalida = $numeroSalida;

        return $this;
    }

    /**
     * Get numeroSalida
     *
     * @return string
     */
    public function getNumeroSalida()
    {
        return $this->numeroSalida;
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
        if ($this->fechaVencimiento) {
            return $this->fechaVencimiento->format('d/m/Y');
        }
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return GdDocumento
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
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
     * Set detalleLlegada
     *
     * @param string $detalleLlegada
     *
     * @return GdDocumento
     */
    public function setDetalleLlegada($detalleLlegada)
    {
        $this->detalleLlegada = $detalleLlegada;

        return $this;
    }

    /**
     * Get detalleLlegada
     *
     * @return string
     */
    public function getDetalleLlegada()
    {
        return $this->detalleLlegada;
    }

    /**
     * Set detalleEnvio
     *
     * @param string $detalleEnvio
     *
     * @return GdDocumento
     */
    public function setDetalleEnvio($detalleEnvio)
    {
        $this->detalleEnvio = $detalleEnvio;

        return $this;
    }

    /**
     * Get detalleEnvio
     *
     * @return string
     */
    public function getDetalleEnvio()
    {
        return $this->detalleEnvio;
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
     * Set estado
     *
     * @param string $estado
     *
     * @return GdDocumento
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
     * Set peticionarioNombres
     *
     * @param string $peticionarioNombres
     *
     * @return GdDocumento
     */
    public function setPeticionarioNombres($peticionarioNombres)
    {
        $this->peticionarioNombres = $peticionarioNombres;

        return $this;
    }

    /**
     * Get peticionarioNombres
     *
     * @return string
     */
    public function getPeticionarioNombres()
    {
        return $this->peticionarioNombres;
    }

    /**
     * Set peticionarioApellidos
     *
     * @param string $peticionarioApellidos
     *
     * @return GdDocumento
     */
    public function setPeticionarioApellidos($peticionarioApellidos)
    {
        $this->peticionarioApellidos = $peticionarioApellidos;

        return $this;
    }

    /**
     * Get peticionarioApellidos
     *
     * @return string
     */
    public function getPeticionarioApellidos()
    {
        return $this->peticionarioApellidos;
    }

    /**
     * Set identificacion
     *
     * @param integer $identificacion
     *
     * @return GdDocumento
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return GdDocumento
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
     * @return GdDocumento
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
     * @return GdDocumento
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
     * Set tipoIdentificacion
     *
     * @param \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion
     *
     * @return GdDocumento
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return GdDocumento
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
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
     * Set medioCorrespondenciaLlegada
     *
     * @param \JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia $medioCorrespondenciaLlegada
     *
     * @return GdDocumento
     */
    public function setMedioCorrespondenciaLlegada(\JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia $medioCorrespondenciaLlegada = null)
    {
        $this->medioCorrespondenciaLlegada = $medioCorrespondenciaLlegada;

        return $this;
    }

    /**
     * Get medioCorrespondenciaLlegada
     *
     * @return \JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia
     */
    public function getMedioCorrespondenciaLlegada()
    {
        return $this->medioCorrespondenciaLlegada;
    }

    /**
     * Set medioCorrespondenciaEnvio
     *
     * @param \JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia $medioCorrespondenciaEnvio
     *
     * @return GdDocumento
     */
    public function setMedioCorrespondenciaEnvio(\JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia $medioCorrespondenciaEnvio = null)
    {
        $this->medioCorrespondenciaEnvio = $medioCorrespondenciaEnvio;

        return $this;
    }

    /**
     * Get medioCorrespondenciaEnvio
     *
     * @return \JHWEB\GestionDocumentalBundle\Entity\GdCfgMedioCorrespondencia
     */
    public function getMedioCorrespondenciaEnvio()
    {
        return $this->medioCorrespondenciaEnvio;
    }

    /**
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return GdDocumento
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }
}
