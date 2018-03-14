<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="factura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacturaRepository")
 */
class Factura
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
     * @var string
     *
     * @ORM\Column(name="numeroFactura", type="string", length=45)
     */
    private $numeroFactura;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoFactura", type="string", length=45)
     */
    private $estadoFactura;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacionesFactura", type="text")
     */
    private $observacionesFactura;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $solicitante;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $apoderado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="facturas")
     **/
    protected $vehiculo;





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
     * Set numeroFactura
     *
     * @param string $numeroFactura
     *
     * @return Factura
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return string
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set estadoFactura
     *
     * @param string $estadoFactura
     *
     * @return Factura
     */
    public function setEstadoFactura($estadoFactura)
    {
        $this->estadoFactura = $estadoFactura;

        return $this;
    }

    /**
     * Get estadoFactura
     *
     * @return string
     */
    public function getEstadoFactura()
    {
        return $this->estadoFactura;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Factura
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set observacionesFactura
     *
     * @param string $observacionesFactura
     *
     * @return Factura
     */
    public function setObservacionesFactura($observacionesFactura)
    {
        $this->observacionesFactura = $observacionesFactura;

        return $this;
    }

    /**
     * Get observacionesFactura
     *
     * @return string
     */
    public function getObservacionesFactura()
    {
        return $this->observacionesFactura;
    }

    /**
     * Set solicitante
     *
     * @param \AppBundle\Entity\Ciudadano $solicitante
     *
     * @return Factura
     */
    public function setSolicitante(\AppBundle\Entity\Ciudadano $solicitante = null)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set apoderado
     *
     * @param \AppBundle\Entity\Ciudadano $apoderado
     *
     * @return Factura
     */
    public function setApoderado(\AppBundle\Entity\Ciudadano $apoderado = null)
    {
        $this->apoderado = $apoderado;

        return $this;
    }

    /**
     * Get apoderado
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getApoderado()
    {
        return $this->apoderado;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Factura
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
