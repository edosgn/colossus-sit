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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_concepto", type="integer", nullable=true)
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

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo", inversedBy="precios") */
    private $tipoVehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgModulo", inversedBy="precios")
     **/
    protected $modulo;

    /**
    * @ORM\OneToMany(targetEntity="FroTrteConcepto", mappedBy="precio", cascade={"remove"})
    */
    private $conceptos;

    public function __construct() {
        $this->conceptos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     *
     * @return FroTrtePrecio
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        if($this->fechaInicial){
            return $this->fechaInicial->format('d/m/Y');
        }
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return FroTrtePrecio
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        if($this->fechaFinal){
            return $this->fechaFinal->format('d/m/Y');
        }
        return $this->fechaFinal;
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
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
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
     * @return integer
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
     * @return integer
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
     * Set tipoVehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo
     *
     * @return FroTrtePrecio
     */
    public function setTipoVehiculo(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
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

    /**
     * Add concepto
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto
     *
     * @return FroTrtePrecio
     */
    public function addConcepto(\JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto)
    {
        $this->conceptos[] = $concepto;

        return $this;
    }

    /**
     * Remove concepto
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto
     */
    public function removeConcepto(\JHWEB\FinancieroBundle\Entity\FroTrteConcepto $concepto)
    {
        $this->conceptos->removeElement($concepto);
    }

    /**
     * Get conceptos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptos()
    {
        return $this->conceptos;
    }
}
