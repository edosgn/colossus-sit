<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTrtePrecio
 *
 * @ORM\Table(name="fro_trte_precio")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTrtePrecioRepository")
 */
class FroTrtePrecio
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_concepto", type="integer")
     */
    private $valorConcepto;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_total", type="integer")
     */
    private $valorTotal;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="FroTramite", inversedBy="precios") */
    private $tramite;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgClase", inversedBy="precios") */
    private $clase;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgModulo", inversedBy="precios")
     **/
    protected $modulo;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FroTrtePrecio
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
     * @return FroTrtePrecio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return int
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
     * @return FroTrtePrecio
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
        if ($this->fechaInicio) {
            return $this->fechaInicio->format('d/m/Y');
        }
    }

    /**
     * Set valorConcepto
     *
     * @param integer $valorConcepto
     *
     * @return FroTrtePrecio
     */
    public function setValorConcepto($valorConcepto)
    {
        $this->valorConcepto = $valorConcepto;

        return $this;
    }

    /**
     * Get valorConcepto
     *
     * @return int
     */
    public function getValorConcepto()
    {
        return $this->valorConcepto;
    }

    /**
     * Set valorTotal
     *
     * @param integer $valorTotal
     *
     * @return FroTrtePrecio
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return int
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTrtePrecio
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
     * Set tramite
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTramite $tramite
     *
     * @return FroTrtePrecio
     */
    public function setTramite(\JHWEB\FinancieroBundle\Entity\FroTramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return FroTrtePrecio
     */
    public function setClase(\JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgClase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set modulo
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgModulo $modulo
     *
     * @return FroTrtePrecio
     */
    public function setModulo(\JHWEB\ConfigBundle\Entity\CfgModulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgModulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
