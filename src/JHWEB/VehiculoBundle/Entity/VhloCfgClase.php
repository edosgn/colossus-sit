<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgClase
 *
 * @ORM\Table(name="vhlo_cfg_clase")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgClaseRepository")
 */
class VhloCfgClase
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
     * @ORM\Column(name="codigo", type="integer", unique=true)
     */
    private $codigo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgTipoVehiculo", inversedBy="clases")
     **/
    private $tipoVehiculo;


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
     * @return VhloCfgClase
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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return VhloCfgClase
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloCfgClase
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
     * Set tipoVehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo
     *
     * @return VhloCfgClase
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
}
