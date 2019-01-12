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
     * @var string
     *
     * @ORM\Column(name="latitud", type="string", length=100, nullable=true)
     */
    private $latitud;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud", type="string", length=100, nullable=true)
     */
    private $longitud;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="adjunto", type="string", length=255, nullable=true)
     */
    private $adjunto;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialConector", inversedBy="ubicaciones") */
    private $conector;

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
     * Set latitud
     *
     * @param string $latitud
     *
     * @return SvSenialUbicacion
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return string
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param string $longitud
     *
     * @return SvSenialUbicacion
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return string
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
     * @return SvSenialUbicacion
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
     * Set conector
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialConector $conector
     *
     * @return SvSenialUbicacion
     */
    public function setConector(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialConector $conector = null)
    {
        $this->conector = $conector;

        return $this;
    }

    /**
     * Get conector
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialConector
     */
    public function getConector()
    {
        return $this->conector;
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
}
