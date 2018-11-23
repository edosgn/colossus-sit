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
     * @ORM\Column(name="latitud", type="string", length=100)
     */
    private $latitud;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud", type="string", length=100)
     */
    private $longitud;

    /**
     * @var string
     *
     * @ORM\Column(name="via_1", type="string", length=50)
     */
    private $via1;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_1", type="integer")
     */
    private $numero1;

    /**
     * @var string
     *
     * @ORM\Column(name="via_2", type="string", length=50)
     */
    private $via2;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_2", type="integer")
     */
    private $numero2;

    /**
     * @var string
     *
     * @ORM\Column(name="via_3", type="string", length=50, nullable=true)
     */
    private $via3;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_3", type="integer", nullable=true)
     */
    private $numero3;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="adjunto", type="string", length=255, nullable=true)
     */
    private $adjunto;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialConector", inversedBy="ubicaciones") */
    private $conector;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialEstado", inversedBy="ubicaciones") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="SvSenial", inversedBy="senialesUbicacion") */
    private $senial;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inventarios") */
    private $municipio;

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
        return $this->fecha;
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
     * Set via1
     *
     * @param string $via1
     *
     * @return SvSenialUbicacion
     */
    public function setVia1($via1)
    {
        $this->via1 = $via1;

        return $this;
    }

    /**
     * Get via1
     *
     * @return string
     */
    public function getVia1()
    {
        return $this->via1;
    }

    /**
     * Set numero1
     *
     * @param integer $numero1
     *
     * @return SvSenialUbicacion
     */
    public function setNumero1($numero1)
    {
        $this->numero1 = $numero1;

        return $this;
    }

    /**
     * Get numero1
     *
     * @return integer
     */
    public function getNumero1()
    {
        return $this->numero1;
    }

    /**
     * Set via2
     *
     * @param string $via2
     *
     * @return SvSenialUbicacion
     */
    public function setVia2($via2)
    {
        $this->via2 = $via2;

        return $this;
    }

    /**
     * Get via2
     *
     * @return string
     */
    public function getVia2()
    {
        return $this->via2;
    }

    /**
     * Set numero2
     *
     * @param integer $numero2
     *
     * @return SvSenialUbicacion
     */
    public function setNumero2($numero2)
    {
        $this->numero2 = $numero2;

        return $this;
    }

    /**
     * Get numero2
     *
     * @return integer
     */
    public function getNumero2()
    {
        return $this->numero2;
    }

    /**
     * Set via3
     *
     * @param string $via3
     *
     * @return SvSenialUbicacion
     */
    public function setVia3($via3)
    {
        $this->via3 = $via3;

        return $this;
    }

    /**
     * Get via3
     *
     * @return string
     */
    public function getVia3()
    {
        return $this->via3;
    }

    /**
     * Set numero3
     *
     * @param integer $numero3
     *
     * @return SvSenialUbicacion
     */
    public function setNumero3($numero3)
    {
        $this->numero3 = $numero3;

        return $this;
    }

    /**
     * Get numero3
     *
     * @return integer
     */
    public function getNumero3()
    {
        return $this->numero3;
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
     * Set valor
     *
     * @param float $valor
     *
     * @return SvSenialUbicacion
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
     * @param \JHWEB\SeguridadVialBundle\Entity\SvSenial $senial
     *
     * @return SvSenialUbicacion
     */
    public function setSenial(\JHWEB\SeguridadVialBundle\Entity\SvSenial $senial = null)
    {
        $this->senial = $senial;

        return $this;
    }

    /**
     * Get senial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvSenial
     */
    public function getSenial()
    {
        return $this->senial;
    }
}
