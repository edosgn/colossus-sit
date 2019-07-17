<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCapacitacion
 *
 * @ORM\Table(name="sv_capacitacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCapacitacionRepository")
 */
class SvCapacitacion
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
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="capacitaciones")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="capacitaciones")
     **/
    protected $empresa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_registro", type="datetime")
     */
    private $fechaHoraRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_actividad", type="date")
     */
    private $fechaActividad;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="capacitaciones")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion", inversedBy="capacitaciones")
     **/
    protected $funcion;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgFuncionCriterio", inversedBy="capacitaciones")
     **/
    protected $funcionCriterio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion", inversedBy="capacitaciones")
     */
    private $temaCapacitacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_actividad", type="string")
     */
    private $descripcionActividad;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion", inversedBy="capacitaciones")
    */
    private $tipoIdentificacionActorVial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_cedula_actor_vial", type="string")
     */
    private $numeroCedulaActorVial;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_actor_vial", type="string")
     */
    private $nombreActorVial;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_actor_vial", type="string")
     */
    private $apellidoActorVial;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimientoActorVial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cargo_actor_vial", type="string", nullable=true)
     */
        private $cargoActorVial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_actor_vial", type="string", nullable=true)
     */
        private $emailActorVial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono_actor_vial", type="string", nullable=true)
     */
        private $telefonoActorVial;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGrupoEtnico", inversedBy="capacitaciones")
     */
    private $grupoEtnicoActorVial;

    /**
     * @var bool
     *
     * @ORM\Column(name="discapacidad", type="boolean", nullable=true)
     */
    private $discapacidad;

    /**
     * @var bool
     *
     * @ORM\Column(name="victima", type="boolean", nullable=true)
     */
    private $victima;

    /**
     * @var bool
     *
     * @ORM\Column(name="comunidad", type="boolean", nullable=true)
     */
    private $comunidad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="capacitaciones")
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia", inversedBy="clasesActores")
     */
    private $claseActorVial;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", nullable = true)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="documento_capacitados", type="string", nullable = true)
     */
    private $documentoCapacitados;

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
     * Set fechaHoraRegistro
     *
     * @param \DateTime $fechaHoraRegistro
     *
     * @return SvCapacitacion
     */
    public function setFechaHoraRegistro($fechaHoraRegistro)
    {
        $this->fechaHoraRegistro = $fechaHoraRegistro;

        return $this;
    }

    /**
     * Get fechaHoraRegistro
     *
     * @return \DateTime
     */
    public function getFechaHoraRegistro()
    {
        return $this->fechaHoraRegistro;
    }

    /**
     * Set fechaActividad
     *
     * @param \DateTime $fechaActividad
     *
     * @return SvCapacitacion
     */
    public function setFechaActividad($fechaActividad)
    {
        $this->fechaActividad = $fechaActividad;

        return $this;
    }

    /**
     * Get fechaActividad
     *
     * @return \DateTime
     */
    public function getFechaActividad()
    {
        return $this->fechaActividad;
    }

    /**
     * Set descripcionActividad
     *
     * @param string $descripcionActividad
     *
     * @return SvCapacitacion
     */
    public function setDescripcionActividad($descripcionActividad)
    {
        $this->descripcionActividad = $descripcionActividad;

        return $this;
    }

    /**
     * Get descripcionActividad
     *
     * @return string
     */
    public function getDescripcionActividad()
    {
        return $this->descripcionActividad;
    }

    /**
     * Set numeroCedulaActorVial
     *
     * @param string $numeroCedulaActorVial
     *
     * @return SvCapacitacion
     */
    public function setNumeroCedulaActorVial($numeroCedulaActorVial)
    {
        $this->numeroCedulaActorVial = $numeroCedulaActorVial;

        return $this;
    }

    /**
     * Get numeroCedulaActorVial
     *
     * @return string
     */
    public function getNumeroCedulaActorVial()
    {
        return $this->numeroCedulaActorVial;
    }

    /**
     * Set nombreActorVial
     *
     * @param string $nombreActorVial
     *
     * @return SvCapacitacion
     */
    public function setNombreActorVial($nombreActorVial)
    {
        $this->nombreActorVial = $nombreActorVial;

        return $this;
    }

    /**
     * Get nombreActorVial
     *
     * @return string
     */
    public function getNombreActorVial()
    {
        return $this->nombreActorVial;
    }

    /**
     * Set apellidoActorVial
     *
     * @param string $apellidoActorVial
     *
     * @return SvCapacitacion
     */
    public function setApellidoActorVial($apellidoActorVial)
    {
        $this->apellidoActorVial = $apellidoActorVial;

        return $this;
    }

    /**
     * Get apellidoActorVial
     *
     * @return string
     */
    public function getApellidoActorVial()
    {
        return $this->apellidoActorVial;
    }

    /**
     * Set fechaNacimientoActorVial
     *
     * @param \DateTime $fechaNacimientoActorVial
     *
     * @return SvCapacitacion
     */
    public function setFechaNacimientoActorVial($fechaNacimientoActorVial)
    {
        $this->fechaNacimientoActorVial = $fechaNacimientoActorVial;

        return $this;
    }

    /**
     * Get fechaNacimientoActorVial
     *
     * @return \DateTime
     */
    public function getFechaNacimientoActorVial()
    {
        return $this->fechaNacimientoActorVial;
    }

    /**
     * Set cargoActorVial
     *
     * @param string $cargoActorVial
     *
     * @return SvCapacitacion
     */
    public function setCargoActorVial($cargoActorVial)
    {
        $this->cargoActorVial = $cargoActorVial;

        return $this;
    }

    /**
     * Get cargoActorVial
     *
     * @return string
     */
    public function getCargoActorVial()
    {
        return $this->cargoActorVial;
    }

    /**
     * Set emailActorVial
     *
     * @param string $emailActorVial
     *
     * @return SvCapacitacion
     */
    public function setEmailActorVial($emailActorVial)
    {
        $this->emailActorVial = $emailActorVial;

        return $this;
    }

    /**
     * Get emailActorVial
     *
     * @return string
     */
    public function getEmailActorVial()
    {
        return $this->emailActorVial;
    }

    /**
     * Set telefonoActorVial
     *
     * @param string $telefonoActorVial
     *
     * @return SvCapacitacion
     */
    public function setTelefonoActorVial($telefonoActorVial)
    {
        $this->telefonoActorVial = $telefonoActorVial;

        return $this;
    }

    /**
     * Get telefonoActorVial
     *
     * @return string
     */
    public function getTelefonoActorVial()
    {
        return $this->telefonoActorVial;
    }

    /**
     * Set discapacidad
     *
     * @param boolean $discapacidad
     *
     * @return SvCapacitacion
     */
    public function setDiscapacidad($discapacidad)
    {
        $this->discapacidad = $discapacidad;

        return $this;
    }

    /**
     * Get discapacidad
     *
     * @return boolean
     */
    public function getDiscapacidad()
    {
        return $this->discapacidad;
    }

    /**
     * Set victima
     *
     * @param boolean $victima
     *
     * @return SvCapacitacion
     */
    public function setVictima($victima)
    {
        $this->victima = $victima;

        return $this;
    }

    /**
     * Get victima
     *
     * @return boolean
     */
    public function getVictima()
    {
        return $this->victima;
    }

    /**
     * Set comunidad
     *
     * @param boolean $comunidad
     *
     * @return SvCapacitacion
     */
    public function setComunidad($comunidad)
    {
        $this->comunidad = $comunidad;

        return $this;
    }

    /**
     * Get comunidad
     *
     * @return boolean
     */
    public function getComunidad()
    {
        return $this->comunidad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCapacitacion
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
     * Set documento
     *
     * @param string $documento
     *
     * @return SvCapacitacion
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set documentoCapacitados
     *
     * @param string $documentoCapacitados
     *
     * @return SvCapacitacion
     */
    public function setDocumentoCapacitados($documentoCapacitados)
    {
        $this->documentoCapacitados = $documentoCapacitados;

        return $this;
    }

    /**
     * Get documentoCapacitados
     *
     * @return string
     */
    public function getDocumentoCapacitados()
    {
        return $this->documentoCapacitados;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return SvCapacitacion
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return SvCapacitacion
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
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return SvCapacitacion
     */
    public function setMunicipio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set funcion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion $funcion
     *
     * @return SvCapacitacion
     */
    public function setFuncion(\JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion $funcion = null)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * Set funcionCriterio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncionCriterio $funcionCriterio
     *
     * @return SvCapacitacion
     */
    public function setFuncionCriterio(\JHWEB\SeguridadVialBundle\Entity\SvCfgFuncionCriterio $funcionCriterio = null)
    {
        $this->funcionCriterio = $funcionCriterio;

        return $this;
    }

    /**
     * Get funcionCriterio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncionCriterio
     */
    public function getFuncionCriterio()
    {
        return $this->funcionCriterio;
    }

    /**
     * Set temaCapacitacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion $temaCapacitacion
     *
     * @return SvCapacitacion
     */
    public function setTemaCapacitacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion $temaCapacitacion = null)
    {
        $this->temaCapacitacion = $temaCapacitacion;

        return $this;
    }

    /**
     * Get temaCapacitacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTemaCapacitacion
     */
    public function getTemaCapacitacion()
    {
        return $this->temaCapacitacion;
    }

    /**
     * Set tipoIdentificacionActorVial
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacionActorVial
     *
     * @return SvCapacitacion
     */
    public function setTipoIdentificacionActorVial(\JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacionActorVial = null)
    {
        $this->tipoIdentificacionActorVial = $tipoIdentificacionActorVial;

        return $this;
    }

    /**
     * Get tipoIdentificacionActorVial
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion
     */
    public function getTipoIdentificacionActorVial()
    {
        return $this->tipoIdentificacionActorVial;
    }

    /**
     * Set grupoEtnicoActorVial
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGrupoEtnico $grupoEtnicoActorVial
     *
     * @return SvCapacitacion
     */
    public function setGrupoEtnicoActorVial(\JHWEB\UsuarioBundle\Entity\UserCfgGrupoEtnico $grupoEtnicoActorVial = null)
    {
        $this->grupoEtnicoActorVial = $grupoEtnicoActorVial;

        return $this;
    }

    /**
     * Get grupoEtnicoActorVial
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgGrupoEtnico
     */
    public function getGrupoEtnicoActorVial()
    {
        return $this->grupoEtnicoActorVial;
    }

    /**
     * Set genero
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgGenero $genero
     *
     * @return SvCapacitacion
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
     * Set claseActorVial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia $claseActorVial
     *
     * @return SvCapacitacion
     */
    public function setClaseActorVial(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia $claseActorVial = null)
    {
        $this->claseActorVial = $claseActorVial;

        return $this;
    }

    /**
     * Get claseActorVial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia
     */
    public function getClaseActorVial()
    {
        return $this->claseActorVial;
    }
}
