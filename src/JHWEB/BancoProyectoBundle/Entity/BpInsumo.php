<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpInsumo
 *
 * @ORM\Table(name="bp_insumo")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpInsumoRepository")
 */
class BpInsumo
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
     * @ORM\Column(name="valor_unitario", type="integer")
     */
    private $valorUnitario;

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

    /**
     * @ORM\ManyToOne(targetEntity="BpCfgTipoInsumo")
     **/
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="BpActividad")
     **/
    protected $actividad;


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
     * @return BpInsumo
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
     * @return BpInsumo
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
     * @return BpInsumo
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set valorUnitario
     *
     * @param integer $valorUnitario
     *
     * @return BpInsumo
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return int
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set valorTotal
     *
     * @param integer $valorTotal
     *
     * @return BpInsumo
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
     * @return BpInsumo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set tipo
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpCfgTipoInsumo $tipo
     *
     * @return BpInsumo
     */
    public function setTipo(\JHWEB\BancoProyectoBundle\Entity\BpCfgTipoInsumo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpCfgTipoInsumo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set actividad
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad
     *
     * @return BpInsumo
     */
    public function setActividad(\JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpActividad
     */
    public function getActividad()
    {
        return $this->actividad;
    }
}
