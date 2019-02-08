<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTrteConcepto
 *
 * @ORM\Table(name="fro_trte_concepto")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTrteConceptoRepository")
 */
class FroTrteConcepto
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroTrtePrecio", inversedBy="conceptos")
     **/
    protected $precio;

    /**
     * @ORM\ManyToOne(targetEntity="FroTrteConcepto", inversedBy="precios")
     **/
    protected $concepto;


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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTrteConcepto
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
     * Set precio
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrtePrecio $precio
     *
     * @return FroTrteConcepto
     */
    public function setPrecio(\JHWEB\FinancieroBundle\Entity\FroTrtePrecio $precio = null)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTrtePrecio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set concepto
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto
     *
     * @return FroTrteConcepto
     */
    public function setConcepto(\JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto = null)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTrteConcepto
     */
    public function getConcepto()
    {
        return $this->concepto;
    }
}
