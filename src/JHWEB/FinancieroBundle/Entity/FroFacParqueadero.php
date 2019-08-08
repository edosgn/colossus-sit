<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacParqueadero
 *
 * @ORM\Table(name="fro_fac_parqueadero")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacParqueaderoRepository")
 */
class FroFacParqueadero
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
     * @ORM\Column(name="minutos", type="integer")
     */
    private $minutos;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_grua", type="integer")
     */
    private $valorGrua;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_parqueadero", type="integer")
     */
    private $valorParqueadero;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_total", type="integer")
     */
    private $valorTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="parqueaderos")
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion", inversedBy="parqueaderos")
     */
    private $inmovilizacion;


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
     * Set minutos
     *
     * @param integer $minutos
     *
     * @return FroFacParqueadero
     */
    public function setMinutos($minutos)
    {
        $this->minutos = $minutos;

        return $this;
    }

    /**
     * Get minutos
     *
     * @return integer
     */
    public function getMinutos()
    {
        return $this->minutos;
    }

    /**
     * Set valorGrua
     *
     * @param integer $valorGrua
     *
     * @return FroFacParqueadero
     */
    public function setValorGrua($valorGrua)
    {
        $this->valorGrua = $valorGrua;

        return $this;
    }

    /**
     * Get valorGrua
     *
     * @return integer
     */
    public function getValorGrua()
    {
        return $this->valorGrua;
    }

    /**
     * Set valorParqueadero
     *
     * @param integer $valorParqueadero
     *
     * @return FroFacParqueadero
     */
    public function setValorParqueadero($valorParqueadero)
    {
        $this->valorParqueadero = $valorParqueadero;

        return $this;
    }

    /**
     * Get valorParqueadero
     *
     * @return integer
     */
    public function getValorParqueadero()
    {
        return $this->valorParqueadero;
    }

    /**
     * Set valorTotal
     *
     * @param integer $valorTotal
     *
     * @return FroFacParqueadero
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return integer
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return FroFacParqueadero
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacParqueadero
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
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacParqueadero
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
     * Set inmovilizacion
     *
     * @param \JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion $inmovilizacion
     *
     * @return FroFacParqueadero
     */
    public function setInmovilizacion(\JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion $inmovilizacion = null)
    {
        $this->inmovilizacion = $inmovilizacion;

        return $this;
    }

    /**
     * Get inmovilizacion
     *
     * @return \JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion
     */
    public function getInmovilizacion()
    {
        return $this->inmovilizacion;
    }
}
