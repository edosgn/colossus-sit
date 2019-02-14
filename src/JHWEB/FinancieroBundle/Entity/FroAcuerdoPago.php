<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroAcuerdoPago
 *
 * @ORM\Table(name="fro_acuerdo_pago")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroAcuerdoPagoRepository")
 */
class FroAcuerdoPago
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
     * @var int
     *
     * @ORM\Column(name="numero_cuotas", type="integer")
     */
    private $numeroCuotas;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10)
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date")
     */
    private $fechaFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="dias_mora_total", type="integer")
     */
    private $diasMoraTotal;

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
     * @var float
     *
     * @ORM\Column(name="valor_cuota_inicial", type="float")
     */
    private $valorCuotaInicial;

    /**
     * @var float
     *
     * @ORM\Column(name="porcentaje_inicial", type="float")
     */
    private $porcentajeInicial;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="sedesOperativas") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCfgInteres", inversedBy="acuerdosPago") */
    private $interes;

 
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
     * @return FroAcuerdoPago
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
     * Set numeroCuotas
     *
     * @param integer $numeroCuotas
     *
     * @return FroAcuerdoPago
     */
    public function setNumeroCuotas($numeroCuotas)
    {
        $this->numeroCuotas = $numeroCuotas;

        return $this;
    }

    /**
     * Get numeroCuotas
     *
     * @return integer
     */
    public function getNumeroCuotas()
    {
        return $this->numeroCuotas;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return FroAcuerdoPago
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
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return FroAcuerdoPago
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return FroAcuerdoPago
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set diasMoraTotal
     *
     * @param integer $diasMoraTotal
     *
     * @return FroAcuerdoPago
     */
    public function setDiasMoraTotal($diasMoraTotal)
    {
        $this->diasMoraTotal = $diasMoraTotal;

        return $this;
    }

    /**
     * Get diasMoraTotal
     *
     * @return integer
     */
    public function getDiasMoraTotal()
    {
        return $this->diasMoraTotal;
    }

    /**
     * Set valorBruto
     *
     * @param float $valorBruto
     *
     * @return FroAcuerdoPago
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
     * @return FroAcuerdoPago
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
     * @return FroAcuerdoPago
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
     * Set valorCuotaInicial
     *
     * @param float $valorCuotaInicial
     *
     * @return FroAcuerdoPago
     */
    public function setValorCuotaInicial($valorCuotaInicial)
    {
        $this->valorCuotaInicial = $valorCuotaInicial;

        return $this;
    }

    /**
     * Get valorCuotaInicial
     *
     * @return float
     */
    public function getValorCuotaInicial()
    {
        return $this->valorCuotaInicial;
    }

    /**
     * Set porcentajeInicial
     *
     * @param float $porcentajeInicial
     *
     * @return FroAcuerdoPago
     */
    public function setPorcentajeInicial($porcentajeInicial)
    {
        $this->porcentajeInicial = $porcentajeInicial;

        return $this;
    }

    /**
     * Get porcentajeInicial
     *
     * @return float
     */
    public function getPorcentajeInicial()
    {
        return $this->porcentajeInicial;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroAcuerdoPago
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
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return FroAcuerdoPago
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set interes
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgInteres $interes
     *
     * @return FroAcuerdoPago
     */
    public function setInteres(\JHWEB\ContravencionalBundle\Entity\CvCfgInteres $interes = null)
    {
        $this->interes = $interes;

        return $this;
    }

    /**
     * Get interes
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgInteres
     */
    public function getInteres()
    {
        return $this->interes;
    }
}
