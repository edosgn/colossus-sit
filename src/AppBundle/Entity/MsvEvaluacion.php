<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvEvaluacion
 *
 * @ORM\Table(name="msv_evaluacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvEvaluacionRepository")
 */
class MsvEvaluacion
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=100)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="parametro", type="string", length=255)
     */
    private $parametro;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="variable", type="string", length=255)
     */
    private $variable;

    /**
     * @var string
     *
     * @ORM\Column(name="criterio", type="string", length=255)
     */
    private $criterio;

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
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


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
     * Set numero
     *
     * @param string $numero
     *
     * @return MsvEvaluacion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set parametro
     *
     * @param string $parametro
     *
     * @return MsvEvaluacion
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;

        return $this;
    }

    /**
     * Get parametro
     *
     * @return string
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set item
     *
     * @param string $item
     *
     * @return MsvEvaluacion
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set variable
     *
     * @param string $variable
     *
     * @return MsvEvaluacion
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Get variable
     *
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * Set criterio
     *
     * @param string $criterio
     *
     * @return MsvEvaluacion
     */
    public function setCriterio($criterio)
    {
        $this->criterio = $criterio;

        return $this;
    }

    /**
     * Get criterio
     *
     * @return string
     */
    public function getCriterio()
    {
        return $this->criterio;
    }

    /**
     * Set aplica
     *
     * @param boolean $aplica
     *
     * @return MsvEvaluacion
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
     * @return MsvEvaluacion
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
     * @return MsvEvaluacion
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return MsvEvaluacion
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
     * @return MsvEvaluacion
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
}

