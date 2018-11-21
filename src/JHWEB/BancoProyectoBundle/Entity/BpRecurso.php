<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpRecurso
 *
 * @ORM\Table(name="bp_recurso")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpRecursoRepository")
 */
class BpRecurso
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidadMedida", type="integer")
     */
    private $cantidadMedida;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var int
     *
     * @ORM\Column(name="valorUnitario", type="integer")
     */
    private $valorUnitario;

    /**
     * @var string
     *
     * @ORM\Column(name="valorTotal", type="string", length=255)
     */
    private $valorTotal;

    /**
     * @ORM\ManyToOne(targetEntity="BpActividad")
     **/
    protected $BpActividad;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BpRecurso
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return BpRecurso
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
     * Set cantidadMedida
     *
     * @param integer $cantidadMedida
     *
     * @return BpRecurso
     */
    public function setCantidadMedida($cantidadMedida)
    {
        $this->cantidadMedida = $cantidadMedida;

        return $this;
    }

    /**
     * Get cantidadMedida
     *
     * @return integer
     */
    public function getCantidadMedida()
    {
        return $this->cantidadMedida;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return BpRecurso
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
     * Set valorUnitario
     *
     * @param integer $valorUnitario
     *
     * @return BpRecurso
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return integer
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set valorTotal
     *
     * @param string $valorTotal
     *
     * @return BpRecurso
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpRecurso
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
     * Set bpActividad
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpActividad $bpActividad
     *
     * @return BpRecurso
     */
    public function setBpActividad(\JHWEB\BancoProyectoBundle\Entity\BpActividad $bpActividad = null)
    {
        $this->BpActividad = $bpActividad;

        return $this;
    }

    /**
     * Get bpActividad
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpActividad
     */
    public function getBpActividad()
    {
        return $this->BpActividad;
    }
}
