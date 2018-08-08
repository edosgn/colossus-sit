<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgFormato
 *
 * @ORM\Table(name="cfg_formato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgFormatoRepository")
 */
class CfgFormato
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
     * @ORM\Column(name="plantilla", type="text")
     */
    private $plantilla;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=10)
     */
    private $version;


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
     * Set plantilla
     *
     * @param string $plantilla
     *
     * @return CfgFormato
     */
    public function setPlantilla($plantilla)
    {
        $this->plantilla = $plantilla;

        return $this;
    }

    /**
     * Get plantilla
     *
     * @return string
     */
    public function getPlantilla()
    {
        return $this->plantilla;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgFormato
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
     * Set version
     *
     * @param string $version
     *
     * @return CfgFormato
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}

