<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCalificacion
 *
 * @ORM\Table(name="sv_calificacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCalificacionRepository")
 */
class SvCalificacion
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
     * @var bool
     *
     * @ORM\Column(name="aplica", type="boolean", nullable=true)
     */
    private $aplica;

    /**
     * @var bool
     *
     * @ORM\Column(name="evidencia", type="boolean", nullable=true)
     */
    private $evidencia;

    /**
     * @var bool
     *
     * @ORM\Column(name="responde", type="boolean", nullable=true)
     */
    private $responde;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido", type="float")
     */
    private $valorObtenido;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
     */
    private $observacion;

    /**
     * @ORM\ManyToOne(targetEntity="SvCfgCriterio")
     **/
    protected $criterio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="calificaciones")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="SvRevision", inversedBy="calificaciones")
     **/
    protected $revision;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo=true;

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
     * Set aplica
     *
     * @param boolean $aplica
     *
     * @return SvCalificacion
     */
    public function setAplica($aplica)
    {
        $this->aplica = $aplica;

        return $this;
    }

    /**
     * Get aplica
     *
     * @return boolean
     */
    public function getAplica()
    {
        return $this->aplica;
    }

    /**
     * Set evidencia
     *
     * @param boolean $evidencia
     *
     * @return SvCalificacion
     */
    public function setEvidencia($evidencia)
    {
        $this->evidencia = $evidencia;

        return $this;
    }

    /**
     * Get evidencia
     *
     * @return boolean
     */
    public function getEvidencia()
    {
        return $this->evidencia;
    }

    /**
     * Set responde
     *
     * @param boolean $responde
     *
     * @return SvCalificacion
     */
    public function setResponde($responde)
    {
        $this->responde = $responde;

        return $this;
    }

    /**
     * Get responde
     *
     * @return boolean
     */
    public function getResponde()
    {
        return $this->responde;
    }

    /**
     * Set valorObtenido
     *
     * @param float $valorObtenido
     *
     * @return SvCalificacion
     */
    public function setValorObtenido($valorObtenido)
    {
        $this->valorObtenido = $valorObtenido;

        return $this;
    }

    /**
     * Get valorObtenido
     *
     * @return float
     */
    public function getValorObtenido()
    {
        return $this->valorObtenido;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return SvCalificacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCalificacion
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
     * Set criterio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCriterio $criterio
     *
     * @return SvCalificacion
     */
    public function setCriterio(\JHWEB\SeguridadVialBundle\Entity\SvCfgCriterio $criterio = null)
    {
        $this->criterio = $criterio;

        return $this;
    }

    /**
     * Get criterio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCriterio
     */
    public function getCriterio()
    {
        return $this->criterio;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return SvCalificacion
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
     * Set revision
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvRevision $revision
     *
     * @return SvCalificacion
     */
    public function setRevision(\JHWEB\SeguridadVialBundle\Entity\SvRevision $revision = null)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvRevision
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
