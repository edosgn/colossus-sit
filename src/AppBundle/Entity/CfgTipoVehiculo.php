<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgTipoVehiculo
 *
 * @ORM\Table(name="cfg_tipo_vehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgTipoVehiculoRepository")
 */
class CfgTipoVehiculo
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="modulos")
     **/
    private $modulo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", length=255)
     */
    private $activo = true;

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
     * @return CfgTipoVehiculo
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
     * @return CfgTipoVehiculo
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
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return CfgTipoVehiculo
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
