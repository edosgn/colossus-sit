<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MrfsvHu08
 *
 * @ORM\Table(name="mrfsv_hu08")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MrfsvHu08Repository")
 */

class MrfsvHu08
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
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=false)
     */
    private $color;

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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MrfsvHu08
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
     * Set unidad
     *
     * @param string $unidad
     *
     * @return MrfsvHu08
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
     * Set color
     *
     * @param string $color
     *
     * @return MrfsvHu08
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set latitud
     *
     * @param float $latitud
     *
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * @return MrfsvHu08
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
     * Set estado
     *
     * @param string $estado
     *
     * @return MrfsvHu08
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return MrfsvHu08
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



