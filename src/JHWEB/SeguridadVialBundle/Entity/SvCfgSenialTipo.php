<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgSenialTipo
 *
 * @ORM\Table(name="sv_cfg_senial_tipo")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgSenialTipoRepository")
 */
class SvCfgSenialTipo
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
     * @return SvCfgSenialTipo
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
     * @return SvCfgSenialTipo
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
     * @return SvCfgSenialTipo
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
