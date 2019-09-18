<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacExcedente
 *
 * @ORM\Table(name="fro_fac_excedente")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacExcedenteRepository")
 */
class FroFacExcedente
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
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var bool
     *
     * @ORM\Column(name="pagado", type="boolean")
     */
    private $pagado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="excedentes")
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="FroFacTramite", inversedBy="excedentes")
     **/
    protected $tramite;


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
     * @return FroFacExcedente
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
     * Set valor
     *
     * @param float $valor
     *
     * @return FroFacExcedente
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
     * Set pagado
     *
     * @param boolean $pagado
     *
     * @return FroFacExcedente
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return bool
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacExcedente
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
     * @return FroFacExcedente
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
     * Set tramite
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFacTramite $tramite
     *
     * @return FroFacExcedente
     */
    public function setTramite(\JHWEB\FinancieroBundle\Entity\FroFacTramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFacTramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }
}
