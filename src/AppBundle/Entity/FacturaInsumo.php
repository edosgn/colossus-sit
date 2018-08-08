<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacturaInsumo
 *
 * @ORM\Table(name="factura_insumo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacturaInsumoRepository")
 */
class FacturaInsumo
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=900, nullable=true)
     */
    private $descripcion;


    /**
     * @var bool
     *
     * @ORM\Column(name="entregado", type="boolean", nullable=true)
     */
    private $entregado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Insumo", inversedBy="facturas")
     **/
    protected $insumo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="facturas")
     **/
    protected $factura;

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
     * @return FacturaInsumo
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return FacturaInsumo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set entregado
     *
     * @param boolean $entregado
     *
     * @return FacturaInsumo
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;

        return $this;
    }

    /**
     * Get entregado
     *
     * @return boolean
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return FacturaInsumo
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
     * Set insumo
     *
     * @param \AppBundle\Entity\Insumo $insumo
     *
     * @return FacturaInsumo
     */
    public function setInsumo(\AppBundle\Entity\Insumo $insumo = null)
    {
        $this->insumo = $insumo;

        return $this;
    }

    /**
     * Get insumo
     *
     * @return \AppBundle\Entity\Insumo
     */
    public function getInsumo()
    {
        return $this->insumo;
    }

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return FacturaInsumo
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
