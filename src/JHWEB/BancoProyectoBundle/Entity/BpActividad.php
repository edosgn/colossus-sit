<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpActividad
 *
 * @ORM\Table(name="bp_actividad")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpActividadRepository")
 */
class BpActividad
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
     * @var string
     *
     * @ORM\Column(name="unidad_medida", type="string", length=255)
     */
    private $unidadMedida;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var int
     *
     * @ORM\Column(name="costo_unitario", type="integer")
     */
    private $costoUnitario;

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
     * @ORM\ManyToOne(targetEntity="BpProyecto")
     **/
    protected $proyecto;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BpActividad
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
     * Set unidadMedida
     *
     * @param string $unidadMedida
     *
     * @return BpActividad
     */
    public function setUnidadMedida($unidadMedida)
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    /**
     * Get unidadMedida
     *
     * @return string
     */
    public function getUnidadMedida()
    {
        return $this->unidadMedida;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return BpActividad
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
     * Set costoUnitario
     *
     * @param integer $costoUnitario
     *
     * @return BpActividad
     */
    public function setCostoUnitario($costoUnitario)
    {
        $this->costoUnitario = $costoUnitario;

        return $this;
    }

    /**
     * Get costoUnitario
     *
     * @return integer
     */
    public function getCostoUnitario()
    {
        return $this->costoUnitario;
    }

    /**
     * Set costoTotal
     *
     * @param integer $costoTotal
     *
     * @return BpActividad
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
     * @return BpActividad
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
     * Set bpProyecto
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpProyecto $bpProyecto
     *
     * @return BpActividad
     */
    public function setBpProyecto(\JHWEB\BancoProyectoBundle\Entity\BpProyecto $bpProyecto = null)
    {
        $this->BpProyecto = $bpProyecto;

        return $this;
    }

    /**
     * Get bpProyecto
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpProyecto
     */
    public function getBpProyecto()
    {
        return $this->BpProyecto;
    }

    /**
     * Set proyecto
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpProyecto $proyecto
     *
     * @return BpActividad
     */
    public function setProyecto(\JHWEB\BancoProyectoBundle\Entity\BpProyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpProyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }
}
