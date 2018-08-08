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
     * @ORM\Column(name="aplica", type="boolean")
     */
    private $aplica;

    /**
     * @var bool
     *
     * @ORM\Column(name="evidencia", type="boolean")
     */
    private $evidencia;

    /**
     * @var bool
     *
     * @ORM\Column(name="responde", type="boolean")
     */
    private $responde;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido", type="integer")
     */
    private $valorObtenido;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=1000)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     **/
    protected $empresa;


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
     * @return bool
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
     * @return bool
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
     * @return bool
     */
    public function getResponde()
    {
        return $this->responde;
    }

    /**
     * Set valorObtenido
     *
     * @param integer $valorObtenido
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
     * @return int
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
     * @return bool
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
     * @return MsvCriterio
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
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Empresa
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}

