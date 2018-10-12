<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgTipoVia
 *
 * @ORM\Table(name="sv_cfg_tipo_via")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgTipoViaRepository")
 */
class SvCfgTipoVia
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
     * @ORM\Column(name="nombre", type="string", nullable= true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea", inversedBy="funciones")
     */
    private $tipoArea;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
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
     * @return SvCfgTipoVia
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
     * @return SvCfgTipoVia
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
     * Set tipoArea
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea $tipoArea
     *
     * @return SvCfgTipoVia
     */
    public function setTipoArea(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea $tipoArea = null)
    {
        $this->tipoArea = $tipoArea;

        return $this;
    }

    /**
     * Get tipoArea
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea
     */
    public function getTipoArea()
    {
        return $this->tipoArea;
    }
}
