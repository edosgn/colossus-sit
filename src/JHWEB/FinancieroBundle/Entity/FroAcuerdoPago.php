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
     * @var int
     *
     * @ORM\Column(name="numCuotas", type="integer")
     */
    private $numCuotas;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="sedesOperativas") */
    private $ciudadano;



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
     * Set numCuotas
     *
     * @param integer $numCuotas
     *
     * @return FroAcuerdoPago
     */
    public function setNumCuotas($numCuotas)
    {
        $this->numCuotas = $numCuotas;

        return $this;
    }

    /**
     * Get numCuotas
     *
     * @return integer
     */
    public function getNumCuotas()
    {
        return $this->numCuotas;
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
}
