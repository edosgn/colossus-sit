<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroAmortizacion
 *
 * @ORM\Table(name="fro_amortizacion")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroAmortizacionRepository")
 */
class FroAmortizacion
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
     * @var int
     *
     * @ORM\Column(name="numero_cuota", type="integer")
     */
    private $numeroCuota;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_limite", type="datetime")
     */
    private $fechaLimite;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_bruto", type="float")
     */
    private $valorBruto;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_mora", type="float")
     */
    private $valorMora;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_neto", type="float")
     */
    private $valorNeto;

    /**
     * @var bool
     *
     * @ORM\Column(name="pagada", type="boolean")
     */
    private $pagada;

    /**
     * @ORM\OneToOne(targetEntity="FroFactura")
     */
    private $factura;

    /** @ORM\ManyToOne(targetEntity="FroAcuerdoPago", inversedBy="acuerdosPago") */
    private $acuerdoPago;


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
     * Set numeroCuota
     *
     * @param integer $numeroCuota
     *
     * @return FroAmortizacion
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numeroCuota = $numeroCuota;

        return $this;
    }

    /**
     * Get numeroCuota
     *
     * @return integer
     */
    public function getNumeroCuota()
    {
        return $this->numeroCuota;
    }

    /**
     * Set fechaLimite
     *
     * @param \DateTime $fechaLimite
     *
     * @return FroAmortizacion
     */
    public function setFechaLimite($fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;

        return $this;
    }

    /**
     * Get fechaLimite
     *
     * @return \DateTime
     */
    public function getFechaLimite()
    {
        if ($this->fechaLimite) {
            return $this->fechaLimite->format('d/m/Y');
        }
        return $this->fechaLimite;
    }

    /**
     * Set valorBruto
     *
     * @param float $valorBruto
     *
     * @return FroAmortizacion
     */
    public function setValorBruto($valorBruto)
    {
        $this->valorBruto = $valorBruto;

        return $this;
    }

    /**
     * Get valorBruto
     *
     * @return float
     */
    public function getValorBruto()
    {
        return $this->valorBruto;
    }

    /**
     * Set valorMora
     *
     * @param float $valorMora
     *
     * @return FroAmortizacion
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
     * Set valorNeto
     *
     * @param float $valorNeto
     *
     * @return FroAmortizacion
     */
    public function setValorNeto($valorNeto)
    {
        $this->valorNeto = $valorNeto;

        return $this;
    }

    /**
     * Get valorNeto
     *
     * @return float
     */
    public function getValorNeto()
    {
        return $this->valorNeto;
    }

    /**
     * Set pagada
     *
     * @param boolean $pagada
     *
     * @return FroAmortizacion
     */
    public function setPagada($pagada)
    {
        $this->pagada = $pagada;

        return $this;
    }

    /**
     * Get pagada
     *
     * @return boolean
     */
    public function getPagada()
    {
        return $this->pagada;
    }

    /**
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroAmortizacion
     */
    public function setFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set acuerdoPago
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroAcuerdoPago $acuerdoPago
     *
     * @return FroAmortizacion
     */
    public function setAcuerdoPago(\JHWEB\FinancieroBundle\Entity\FroAcuerdoPago $acuerdoPago = null)
    {
        $this->acuerdoPago = $acuerdoPago;

        return $this;
    }

    /**
     * Get acuerdoPago
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroAcuerdoPago
     */
    public function getAcuerdoPago()
    {
        return $this->acuerdoPago;
    }
}
