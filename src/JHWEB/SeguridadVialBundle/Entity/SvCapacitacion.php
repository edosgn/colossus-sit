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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="hora", type="string")
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="formador", type="string")
     */
    private $formador;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula", type="string")
     */
    private $cedula;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="municipios")
     **/
    protected $municipio;

    /**
     * @var string
     *
     * @ORM\Column(name="funcion_seguridad_vial", type="string")
     */
    private $funcionSeguridadVial;



    /**
     * @var string
     *
     * @ORM\Column(name="clase_actividad", type="string")
     */
    private $claseActividad;

    /**
     * @var string
     *
     * @ORM\Column(name="tema_capacitacion", type="string")
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
     * @ORM\Column(name="clase_actor_vial", type="string")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvCapacitacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;

    }

    /**
     * Set hora
     *
     * @param string $hora
     *
     * @return SvCapacitacion
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return string
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set formador
     *
     * @param string $formador
     *
     * @return SvCapacitacion
     */
    public function setFormador($formador)
    {
        $this->formador = $formador;

        return $this;
    }

    /**
     * Get formador
     *
     * @return string
     */
    public function getFormador()
    {
        return $this->formador;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     *
     * @return SvCapacitacion
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return string
     */
    public function getCedula()
    {
        return $this->cedula;
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
        if ($this->fechaActividad) {
            return $this->fechaActividad->format('d/m/Y');
        }
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
     * Set funcionSeguridadVial
     *
     * @param string $funcionSeguridadVial
     *
     * @return SvCapacitacion
     */
    public function setFuncionSeguridadVial($funcionSeguridadVial)
    {
        $this->funcionSeguridadVial = $funcionSeguridadVial;

        return $this;
    }

    /**
     * Get funcionSeguridadVial
     *
     * @return string
     */
    public function getFuncionSeguridadVial()
    {
        return $this->funcionSeguridadVial;
    }

    /**
     * Set claseActividad
     *
     * @param string $claseActividad
     *
     * @return SvCapacitacion
     */
    public function setClaseActividad($claseActividad)
    {
        $this->claseActividad = $claseActividad;

        return $this;
    }

    /**
     * Get claseActividad
     *
     * @return string
     */
    public function getClaseActividad()
    {
        return $this->claseActividad;
    }

    /**
     * Set temaCapacitacion
     *
     * @param string $temaCapacitacion
     *
     * @return SvCapacitacion
     */
    public function setTemaCapacitacion($temaCapacitacion)
    {
        $this->temaCapacitacion = $temaCapacitacion;

        return $this;
    }

    /**
     * Get temaCapacitacion
     *
     * @return string
     */
    public function getTemaCapacitacion()
    {
        return $this->temaCapacitacion;
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
     * Set claseActorVial
     *
     * @param string $claseActorVial
     *
     * @return SvCapacitacion
     */
    public function setClaseActorVial($claseActorVial)
    {
        $this->claseActorVial = $claseActorVial;

        return $this;
    }

    /**
     * Get claseActorVial
     *
     * @return string
     */
    public function getClaseActorVial()
    {
        return $this->claseActorVial;
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return SvCapacitacion
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
}
