<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvCalificacion
 *
 * @ORM\Table(name="msv_calificacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvCalificacionRepository")
 */
class MsvCalificacion
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
     * @ORM\Column(name="observacion", type="string", length=1000, nullable=true)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvCriterio")
     **/
    protected $criterio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="capacitaciones")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvRevision", inversedBy="calificaciones")
     **/
    protected $revision;


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
     * @return MsvCalificacion
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
     * @return MsvCalificacion
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
     * @return MsvCalificacion
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
     * @return MsvCalificacion
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
     * @return MsvCalificacion
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MsvCalificacion
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
     * Set criterio
     *
     * @param \AppBundle\Entity\MsvCriterio $criterio
     *
     * @return MsvCalificacion
     */
    public function setCriterio(\AppBundle\Entity\MsvCriterio $criterio = null)
    {
        $this->criterio = $criterio;

        return $this;
    }

    /**
     * Get criterio
     *
     * @return \AppBundle\Entity\MsvCriterio
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
     * @return MsvCalificacion
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
     * @param \AppBundle\Entity\MsvRevision $revision
     *
     * @return MsvCalificacion
     */
    public function setRevision(\AppBundle\Entity\MsvRevision $revision = null)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return \AppBundle\Entity\MsvRevision
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
