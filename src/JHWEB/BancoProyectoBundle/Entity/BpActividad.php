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
     * @ORM\ManyToOne(targetEntity="BpCuenta")
     **/
    protected $cuenta;


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
     * @param string $numero
     *
     * @return BpActividad
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
     * Set cuenta
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpCuenta $cuenta
     *
     * @return BpActividad
     */
    public function setCuenta(\JHWEB\BancoProyectoBundle\Entity\BpCuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpCuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }
}
