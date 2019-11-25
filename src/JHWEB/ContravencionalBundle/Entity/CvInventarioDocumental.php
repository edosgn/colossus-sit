<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvInventarioDocumental
 *
 * @ORM\Table(name="cv_inventario_documental")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvInventarioDocumentalRepository")
 */
class CvInventarioDocumental
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
     * @var int
     *
     * @ORM\Column(name="numero_orden", type="integer")
     */
    private $numeroOrden;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=100)
     */
    private $tipo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date")
     */
    private $fechaFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="caja", type="integer")
     */
    private $caja;

    /**
     * @var int
     *
     * @ORM\Column(name="carpeta", type="integer")
     */
    private $carpeta;

    /**
     * @var int
     *
     * @ORM\Column(name="folios", type="integer", nullable=true)
     */
    private $folios;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * Set numeroOrden
     *
     * @param integer $numeroOrden
     *
     * @return CvInventarioDocumental
     */
    public function setNumeroOrden($numeroOrden)
    {
        $this->numeroOrden = $numeroOrden;

        return $this;
    }

    /**
     * Get numeroOrden
     *
     * @return int
     */
    public function getNumeroOrden()
    {
        return $this->numeroOrden;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return CvInventarioDocumental
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return CvInventarioDocumental
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     *
     * @return CvInventarioDocumental
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
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return CvInventarioDocumental
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
        return $this->fechaFinal;
    }

    /**
     * Set caja
     *
     * @param integer $caja
     *
     * @return CvInventarioDocumental
     */
    public function setCaja($caja)
    {
        $this->caja = $caja;

        return $this;
    }

    /**
     * Get caja
     *
     * @return int
     */
    public function getCaja()
    {
        return $this->caja;
    }

    /**
     * Set carpeta
     *
     * @param integer $carpeta
     *
     * @return CvInventarioDocumental
     */
    public function setCarpeta($carpeta)
    {
        $this->carpeta = $carpeta;

        return $this;
    }

    /**
     * Get carpeta
     *
     * @return integer
     */
    public function getCarpeta()
    {
        return $this->carpeta;
    }

    /**
     * Set folios
     *
     * @param integer $folios
     *
     * @return CvInventarioDocumental
     */
    public function setFolios($folios)
    {
        $this->folios = $folios;

        return $this;
    }

    /**
     * Get folios
     *
     * @return integer
     */
    public function getFolios()
    {
        return $this->folios;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvInventarioDocumental
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
}
