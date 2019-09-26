<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacTransferencia
 *
 * @ORM\Table(name="fro_fac_transferencia")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacTransferenciaRepository")
 */
class FroFacTransferencia
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
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_sttdn", type="float")
     */
    private $valorSttdn;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_simit", type="float")
     */
    private $valorSimit;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_polca", type="float")
     */
    private $valorPolca;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=50)
     */
    private $tipo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura")
     */
    private $factura; 

    /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCdoComparendo", inversedBy="transferencias") */
    private $comparendo;


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
     * @return FroFacTransferencia
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return FroFacTransferencia
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set valorSttdn
     *
     * @param float $valorSttdn
     *
     * @return FroFacTransferencia
     */
    public function setValorSttdn($valorSttdn)
    {
        $this->valorSttdn = $valorSttdn;

        return $this;
    }

    /**
     * Get valorSttdn
     *
     * @return float
     */
    public function getValorSttdn()
    {
        return $this->valorSttdn;
    }

    /**
     * Set valorSimit
     *
     * @param float $valorSimit
     *
     * @return FroFacTransferencia
     */
    public function setValorSimit($valorSimit)
    {
        $this->valorSimit = $valorSimit;

        return $this;
    }

    /**
     * Get valorSimit
     *
     * @return float
     */
    public function getValorSimit()
    {
        return $this->valorSimit;
    }

    /**
     * Set valorPolca
     *
     * @param float $valorPolca
     *
     * @return FroFacTransferencia
     */
    public function setValorPolca($valorPolca)
    {
        $this->valorPolca = $valorPolca;

        return $this;
    }

    /**
     * Get valorPolca
     *
     * @return float
     */
    public function getValorPolca()
    {
        return $this->valorPolca;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return FroFacTransferencia
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacTransferencia
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacTransferencia
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
     * Set comparendo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo
     *
     * @return FroFacTransferencia
     */
    public function setComparendo(\JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }
}
