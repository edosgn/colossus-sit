<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramitePrecio
 *
 * @ORM\Table(name="tramite_precio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramitePrecioRepository")
 */
class TramitePrecio
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
     * @ORM\Column(name="valor", type="string", length=255, nullable = true)
     */
    private $valor;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fechaInicio;

    
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="valorTotal", type="text", nullable=true)
     */
    private $valorTotal;



    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="vehiculos") */
    private $tramite;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculos") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="vehiculos") */
    private $modulo;



    

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
     * Set valor
     *
     * @param string $valor
     *
     * @return TramitePrecio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return TramitePrecio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio->format('Y-m-d');
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TramitePrecio
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramitePrecio
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return TramitePrecio
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
     * Set valorTotal
     *
     * @param string $valorTotal
     *
     * @return TramitePrecio
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return string
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return TramitePrecio
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return TramitePrecio
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return TramitePrecio
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
