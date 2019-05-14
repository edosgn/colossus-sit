<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacInsumo
 *
 * @ORM\Table(name="fro_fac_insumo")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacInsumoRepository")
 */
class FroFacInsumo
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="entregado", type="boolean")
     */
    private $entregado;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="facturas")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\InsumoBundle\Entity\ImoInsumo", inversedBy="facturas")
     **/
    protected $insumo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\FinancieroBundle\Entity\FroFactura", inversedBy="facturas")
     **/
    protected $factura;


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
     * @return FroFacInsumo
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
     * @return FroFacInsumo
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
     * @return FroFacInsumo
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;

        return $this;
    }

    /**
     * Get entregado
     *
     * @return bool
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return FroFacInsumo
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set insumo
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoInsumo $insumo
     *
     * @return FroFacInsumo
     */
    public function setInsumo(\JHWEB\InsumoBundle\Entity\ImoInsumo $insumo = null)
    {
        $this->insumo = $insumo;

        return $this;
    }

    /**
     * Get insumo
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoInsumo
     */
    public function getInsumo()
    {
        return $this->insumo;
    }

    /**
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacInsumo
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
}
