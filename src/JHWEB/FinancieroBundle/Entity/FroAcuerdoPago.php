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
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var float
     *
     * @ORM\Column(name="valorCuotaInicial", type="float")
     */
    private $valorCuotaInicial;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="sedesOperativas") */
    private $ciudadano;

     /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial", inversedBy="acuerdosPago") */
     private $porcentajeInicial;

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
     * Set valor
     *
     * @param float $valor
     *
     * @return FroAcuerdoPago
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
     * Set porcentajeInicial
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial $porcentajeInicial
     *
     * @return FroAcuerdoPago
     */
    public function setPorcentajeInicial(\JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial $porcentajeInicial = null)
    {
        $this->porcentajeInicial = $porcentajeInicial;

        return $this;
    }

    /**
     * Get porcentajeInicial
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial
     */
    public function getPorcentajeInicial()
    {
        return $this->porcentajeInicial;
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
