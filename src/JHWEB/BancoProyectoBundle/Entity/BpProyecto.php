<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpProyecto
 *
 * @ORM\Table(name="bp_proyecto")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpProyectoRepository")
 */
class BpProyecto
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
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="cuenta_numero", type="integer")
     */
    private $cuentaNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta_nombre", type="string", length=255)
     */
    private $cuentaNombre;

    /**
     * @var int
     *
     * @ORM\Column(name="costo_total", type="integer")
     */
    private $costoTotal;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return BpProyecto
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BpProyecto
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BpProyecto
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
     * Set cuentaNumero
     *
     * @param integer $cuentaNumero
     *
     * @return BpProyecto
     */
    public function setCuentaNumero($cuentaNumero)
    {
        $this->cuentaNumero = $cuentaNumero;

        return $this;
    }

    /**
     * Get cuentaNumero
     *
     * @return integer
     */
    public function getCuentaNumero()
    {
        return $this->cuentaNumero;
    }

    /**
     * Set cuentaNombre
     *
     * @param string $cuentaNombre
     *
     * @return BpProyecto
     */
    public function setCuentaNombre($cuentaNombre)
    {
        $this->cuentaNombre = $cuentaNombre;

        return $this;
    }

    /**
     * Get cuentaNombre
     *
     * @return string
     */
    public function getCuentaNombre()
    {
        return $this->cuentaNombre;
    }

    /**
     * Set costoTotal
     *
     * @param integer $costoTotal
     *
     * @return BpProyecto
     */
    public function setCostoTotal($costoTotal)
    {
        $this->costoTotal = $costoTotal;

        return $this;
    }

    /**
     * Get costoTotal
     *
     * @return integer
     */
    public function getCostoTotal()
    {
        return $this->costoTotal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpProyecto
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
