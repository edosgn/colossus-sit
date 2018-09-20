<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvAcuerdoPago
 *
 * @ORM\Table(name="cv_acuerdo_pago")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvAcuerdoPagoRepository")
 */
class CvAcuerdoPago
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
     * @var int
     *
     * @ORM\Column(name="cuotas_pagadas", type="integer")
     */
    private $cuotasPagadas;

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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="CvCfgPorcentajeInicial", inversedBy="acuerdosPago") */
    private $porcentajeInicial;

    /** @ORM\ManyToOne(targetEntity="CvCfgInteres", inversedBy="acuerdosPago") */
    private $interes;


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
     * @return CvAcuerdoPago
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
     * @return CvAcuerdoPago
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
     * Set cuotasPagadas
     *
     * @param integer $cuotasPagadas
     *
     * @return CvAcuerdoPago
     */
    public function setCuotasPagadas($cuotasPagadas)
    {
        $this->cuotasPagadas = $cuotasPagadas;

        return $this;
    }

    /**
     * Get cuotasPagadas
     *
     * @return integer
     */
    public function getCuotasPagadas()
    {
        return $this->cuotasPagadas;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return CvAcuerdoPago
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
     * @return CvAcuerdoPago
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
     * @return CvAcuerdoPago
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvAcuerdoPago
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
     * Set porcentajeInicial
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial $porcentajeInicial
     *
     * @return CvAcuerdoPago
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
     * @return CvAcuerdoPago
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
