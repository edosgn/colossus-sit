<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvRecaudo
 *
 * @ORM\Table(name="cv_recaudo")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvRecaudoRepository")
 */
class CvRecaudo
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
     * @var float
     *
     * @ORM\Column(name="valor_interes", type="float")
     */
    private $valorInteres;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_mora", type="float")
     */
    private $valorMora;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_capital", type="float")
     */
    private $valorCapital;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_total", type="float")
     */
    private $valorTotal;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="CvAcuerdoPago", inversedBy="recaudos") */
    private $acuerdoPago;

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
     * Set valorInteres
     *
     * @param float $valorInteres
     *
     * @return CvRecaudo
     */
    public function setValorInteres($valorInteres)
    {
        $this->valorInteres = $valorInteres;

        return $this;
    }

    /**
     * Get valorInteres
     *
     * @return float
     */
    public function getValorInteres()
    {
        return $this->valorInteres;
    }

    /**
     * Set valorMora
     *
     * @param float $valorMora
     *
     * @return CvRecaudo
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
     * Set valorCapital
     *
     * @param float $valorCapital
     *
     * @return CvRecaudo
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
     * Set valorTotal
     *
     * @param float $valorTotal
     *
     * @return CvRecaudo
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return float
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvRecaudo
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
     * Set acuerdoPago
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago $acuerdoPago
     *
     * @return CvRecaudo
     */
    public function setAcuerdoPago(\JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago $acuerdoPago = null)
    {
        $this->acuerdoPago = $acuerdoPago;

        return $this;
    }

    /**
     * Get acuerdoPago
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvAcuerdoPago
     */
    public function getAcuerdoPago()
    {
        return $this->acuerdoPago;
    }
}
