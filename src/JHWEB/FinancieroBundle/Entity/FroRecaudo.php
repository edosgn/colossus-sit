<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroRecaudo
 *
 * @ORM\Table(name="fro_recaudo")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroRecaudoRepository")
 */
class FroRecaudo
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var float
     *
     * @ORM\Column(name="valorMora", type="float")
     */
    private $valorMora;

    /**
     * @var float
     *
     * @ORM\Column(name="valorFinanciacion", type="float")
     */
    private $valorFinanciacion;

    /**
     * @var float
     *
     * @ORM\Column(name="valorCapital", type="float")
     */
    private $valorCapital;

    /**
     * @var float
     *
     * @ORM\Column(name="valorDescuento", type="float")
     */
    private $valorDescuento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura")
     */
    private $froFactura;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="sedesOperativas") */
    private $sedeOperativa;
    

   

    /**
     * Get id
     *
     * @return integer
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
     * @return FroRecaudo
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
            return $this->fecha->format('Y-m-d');
        }else{
            return $this->fecha;
        }
    }

    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return FroRecaudo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorMora
     *
     * @param float $valorMora
     *
     * @return FroRecaudo
     */
    public function setValorMora($valorMora)
    {
        $this->valorMora = $valorMora;

        return $this;
    }

    /**
     * Get valorMora
     *
     * @return float
     */
    public function getValorMora()
    {
        return $this->valorMora;
    }

    /**
     * Set valorFinanciacion
     *
     * @param float $valorFinanciacion
     *
     * @return FroRecaudo
     */
    public function setValorFinanciacion($valorFinanciacion)
    {
        $this->valorFinanciacion = $valorFinanciacion;

        return $this;
    }

    /**
     * Get valorFinanciacion
     *
     * @return float
     */
    public function getValorFinanciacion()
    {
        return $this->valorFinanciacion;
    }

    /**
     * Set valorCapital
     *
     * @param float $valorCapital
     *
     * @return FroRecaudo
     */
    public function setValorCapital($valorCapital)
    {
        $this->valorCapital = $valorCapital;

        return $this;
    }

    /**
     * Get valorCapital
     *
     * @return float
     */
    public function getValorCapital()
    {
        return $this->valorCapital;
    }

    /**
     * Set valorDescuento
     *
     * @param float $valorDescuento
     *
     * @return FroRecaudo
     */
    public function setValorDescuento($valorDescuento)
    {
        $this->valorDescuento = $valorDescuento;

        return $this;
    }

    /**
     * Get valorDescuento
     *
     * @return float
     */
    public function getValorDescuento()
    {
        return $this->valorDescuento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroRecaudo
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
     * Set froFactura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $froFactura
     *
     * @return FroRecaudo
     */
    public function setFroFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $froFactura = null)
    {
        $this->froFactura = $froFactura;

        return $this;
    }

    /**
     * Get froFactura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFroFactura()
    {
        return $this->froFactura;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return FroRecaudo
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
}
