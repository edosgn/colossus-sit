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
     * @ORM\Column(name="horas", type="integer")
     */
    private $horas;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_hora", type="integer")
     */
    private $valorHora;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=10)
     */
    private $placa;

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
     * Set horas
     *
     * @param integer $horas
     *
     * @return FroFacParqueadero
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas
     *
     * @return integer
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set valorHora
     *
     * @param integer $valorHora
     *
     * @return FroFacParqueadero
     */
    public function setValorHora($valorHora)
    {
        $this->valorHora = $valorHora;

        return $this;
    }

    /**
     * Get valorHora
     *
     * @return integer
     */
    public function getValorHora()
    {
        return $this->valorHora;
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
     * Set placa
     *
     * @param string $placa
     *
     * @return FroFacParqueadero
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
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
