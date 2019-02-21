<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgTipoVehiculo
 *
 * @ORM\Table(name="vhlo_cfg_tipo_vehiculo")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgTipoVehiculoRepository")
 */
class VhloCfgTipoVehiculo
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgModulo", inversedBy="modulos")
     **/
    private $modulo;


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
     * @return VhloCfgTipoVehiculo
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloCfgTipoVehiculo
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
     * Set modulo
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgModulo $modulo
     *
     * @return VhloCfgTipoVehiculo
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
}
