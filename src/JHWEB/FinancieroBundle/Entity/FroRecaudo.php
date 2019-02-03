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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura")
     */
    private $froFactura; 

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="recaudos") */
    private $organismoTransito;
    
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return FroRecaudo
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
