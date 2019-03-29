<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalCfgCargo
 *
 * @ORM\Table(name="pnal_cfg_cargo")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalCfgCargoRepository")
 */
class PnalCfgCargo
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
     * @ORM\Column(name="gestionable", type="boolean")
     */
    private $gestionable;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * @return PnalCfgCargo
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
     * Set gestionable
     *
     * @param boolean $gestionable
     *
     * @return PnalCfgCargo
     */
    public function setGestionable($gestionable)
    {
        $this->gestionable = $gestionable;

        return $this;
    }

    /**
     * Get gestionable
     *
     * @return boolean
     */
    public function getGestionable()
    {
        return $this->gestionable;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalCfgCargo
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
