<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialUbicacion
 *
 * @ORM\Table(name="sv_senial_ubicacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialUbicacionRepository")
 */
class SvSenialUbicacion
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
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var array
     *
     * @ORM\Column(name="geolocalizacion", type="array", nullable=true)
     */
    private $geolocalizacion;

    /**
     * @var string
     *
     * @ORM\Column(name="adjunto", type="string", length=255, nullable=true)
     */
    private $adjunto;

    /**
     * @var string
     *
     * @ORM\Column(name="proveedor", type="string", length=255, nullable=true)
     */
    private $proveedor;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialEstado", inversedBy="ubicaciones") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenial", inversedBy="ubicaciones") */
    private $senial;

    /** @ORM\ManyToOne(targetEntity="SvSenialInventario", inversedBy="ubicaciones") */
    private $inventario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="ubicaciones") */
    private $municipio;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialLinea", inversedBy="ubicaciones") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialUnidadMedida", inversedBy="ubicaciones") */
    private $unidadMedida;

    /** @ORM\ManyToOne(targetEntity="SvSenialBodega", inversedBy="ubicaciones") */
    private $bodega;

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
     * @return SvSenialUbicacion
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return SvSenialUbicacion
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        if ($this->hora) {
            return $this->hora->format('h:m:s A');
        }
        return $this->hora;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return SvSenialUbicacion
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
     * Set geolocalizacion
     *
     * @param array $geolocalizacion
     *
     * @return SvSenialUbicacion
     */
    public function setGeolocalizacion($geolocalizacion)
    {
        $this->geolocalizacion = $geolocalizacion;

        return $this;
    }

    /**
     * Get geolocalizacion
     *
     * @return array
     */
    public function getGeolocalizacion()
    {
        return $this->geolocalizacion;
    }

    /**
     * Set adjunto
     *
     * @param string $adjunto
     *
     * @return SvSenialUbicacion
     */
    public function setAdjunto($adjunto)
    {
        $this->adjunto = $adjunto;

        return $this;
    }

    /**
     * Get adjunto
     *
     * @return string
     */
    public function getAdjunto()
    {
        return $this->adjunto;
    }

    /**
     * Set estado
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado $estado
     *
     * @return SvSenialUbicacion
     */
    public function setEstado(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set senial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenial $senial
     *
     * @return SvSenialUbicacion
     */
    public function setSenial(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenial $senial = null)
    {
        $this->senial = $senial;

        return $this;
    }

    /**
     * Get senial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenial
     */
    public function getSenial()
    {
        return $this->senial;
    }

    /**
     * Set inventario
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenialInventario $inventario
     *
     * @return SvSenialUbicacion
     */
    public function setInventario(\JHWEB\SeguridadVialBundle\Entity\SvSenialInventario $inventario = null)
    {
        $this->inventario = $inventario;

        return $this;
    }

    /**
     * Get inventario
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenialInventario
     */
    public function getInventario()
    {
        return $this->inventario;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return SvSenialUbicacion
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set linea
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea $linea
     *
     * @return SvSenialUbicacion
     */
    public function setLinea(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialLinea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set unidadMedida
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida $unidadMedida
     *
     * @return SvSenialUbicacion
     */
    public function setUnidadMedida(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida $unidadMedida = null)
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    /**
     * Get unidadMedida
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialUnidadMedida
     */
    public function getUnidadMedida()
    {
        return $this->unidadMedida;
    }

    /**
     * Set bodega
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenialBodega $bodega
     *
     * @return SvSenialUbicacion
     */
    public function setBodega(\JHWEB\SeguridadVialBundle\Entity\SvSenialBodega $bodega = null)
    {
        $this->bodega = $bodega;

        return $this;
    }

    /**
     * Get bodega
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenialBodega
     */
    public function getBodega()
    {
        return $this->bodega;
    }

    /**
     * Set proveedor
     *
     * @param string $proveedor
     *
     * @return SvSenialUbicacion
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return string
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }
}
