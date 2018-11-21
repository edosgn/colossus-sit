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
     * @ORM\Column(name="numeroCuota", type="integer")
     */
    private $numeroCuota;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreCuota", type="string", length=255)
     */
    private $nombreCuota;

    /**
     * @var int
     *
     * @ORM\Column(name="costoValor", type="integer")
     */
    private $costoValor;

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
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Set numeroCuota
     *
     * @param integer $numeroCuota
     *
     * @return BpProyecto
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numeroCuota = $numeroCuota;

        return $this;
    }

    /**
     * Get numeroCuota
     *
     * @return integer
     */
    public function getNumeroCuota()
    {
        return $this->numeroCuota;
    }

    /**
     * Set nombreCuota
     *
     * @param string $nombreCuota
     *
     * @return BpProyecto
     */
    public function setNombreCuota($nombreCuota)
    {
        $this->nombreCuota = $nombreCuota;

        return $this;
    }

    /**
     * Get nombreCuota
     *
     * @return string
     */
    public function getNombreCuota()
    {
        return $this->nombreCuota;
    }

    /**
     * Set costoValor
     *
     * @param integer $costoValor
     *
     * @return BpProyecto
     */
    public function setCostoValor($costoValor)
    {
        $this->costoValor = $costoValor;

        return $this;
    }

    /**
     * Get costoValor
     *
     * @return integer
     */
    public function getCostoValor()
    {
        return $this->costoValor;
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
