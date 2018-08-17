<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvInventarioSenial
 *
 * @ORM\Table(name="msv_inventario_senial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvInventarioSenialRepository")
 */

class MsvInventarioSenial
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id; 
	
	/**
     * @var \Inventario
     *
     * @ORM\ManyToOne(targetEntity="CfgInventario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventario_id", referencedColumnName="id")
     * })
     */
    private $inventario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255, nullable=false)
     */
    private $unidad;
	
	/**
     * @var \TipoColor
     *
     * @ORM\ManyToOne(targetEntity="CfgTipoColor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_color_id", referencedColumnName="id")
     * })
     */
    private $tipoColor;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="float", precision=10, scale=6, nullable=false)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float", precision=10, scale=6, nullable=false)
     */
    private $longitud;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=500, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="integer", nullable=false)
     */
    private $valor;

    /**
     * @var \TipoEstado
     *
     * @ORM\ManyToOne(targetEntity="CfgTipoEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_estado_id", referencedColumnName="id")
     * })
     */
    private $tipoEstado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * Set inventario
     *
     * @param \AppBundle\Entity\CfgInventario $inventario
     *
     * @return MsvInventarioSenial
     */
    public function setInventario(\AppBundle\Entity\CfgInventario $inventario = null)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return \AppBundle\Entity\CfgInventario
     */
    public function getInventario()
    {
        return $this->inventario;
    }
	
	/**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MsvInventarioSenial
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
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     *
     * @return MsvInventarioSenial
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
	
	/**
     * Set senal
     *
     * @param \AppBundle\Entity\CfgTipoColor $tipoColor
     *
     * @return MsvSenial
     */
    public function setTipoColor(\AppBundle\Entity\CfgTipoColor $tipoColor = null)
    {
        $this->tipoColor = $tipoColor;

        return $this;
    }

    /**
     * Get tipoSenal
     *
     * @return \AppBundle\Entity\CfgTipoColor
     */
    public function getTipoColor()
    {
        return $this->tipoColor;
    }


    /**
     * Set latitud
     *
     * @param float $latitud
     *
     * @return MsvInventarioSenial
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return float
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     *
     * @return MsvInventarioSenial
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return float
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return MsvInventarioSenial
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return MsvInventarioSenial
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return MsvInventarioSenial
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return MsvInventarioSenial
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return MsvInventarioSenial
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }


    /**
     * Set senal
     *
     * @param \AppBundle\Entity\CfgTipoEstado $tipoEstado
     *
     * @return MsvSenial
     */
    public function setTipoEstado(\AppBundle\Entity\CfgTipoEstado $tipoEstado = null)
    {
        $this->tipoEstado = $tipoEstado;

        return $this;
    }

    /**
     * Get tipoEstado
     *
     * @return \AppBundle\Entity\CfgTipoEstado
     */
    public function getTipoEstado()
    {
        return $this->tipoEstado;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return MsvInventarioSenial
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return MsvInventarioSenial
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return "";
    }
}



