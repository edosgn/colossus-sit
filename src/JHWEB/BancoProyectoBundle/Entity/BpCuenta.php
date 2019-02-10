<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpCuenta
 *
 * @ORM\Table(name="bp_cuenta")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpCuentaRepository")
 */
class BpCuenta
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
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return BpCuenta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
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
     * @return BpCuenta
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
     * Set costoTotal
     *
     * @param integer $costoTotal
     *
     * @return BpCuenta
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
     * @return BpCuenta
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
     * Set proyecto
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpProyecto $proyecto
     *
     * @return BpCuenta
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
