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
     * @var string
     *
     * @ORM\Column(name="semana", type="string")
     */
    private $semana;

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
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="capacitaciones")
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_actividad", type="string")
     */
    private $descripcionActividad;

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
     * @var string
     *
     * @ORM\Column(name="numero_cedula_actor_vial", type="string")
     */
    private $numeroCedulaActorVial;

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
     * @ORM\Column(name="documento", type="string")
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="documento_capacitados", type="string")
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
        if ($this->fechaHoraRegistro) {
            return $this->fechaHoraRegistro->format('d/m/Y h:i:s A');
        }
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
     * Set semana
     *
     * @param string $semana
     *
     * @return SvCapacitacion
     */
    public function setSemana($semana)
    {
        $this->semana = $semana;

        return $this;
    }

    /**
     * Get semana
     *
     * @return string
     */
    public function getSemana()
    {
        return $this->semana;
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
