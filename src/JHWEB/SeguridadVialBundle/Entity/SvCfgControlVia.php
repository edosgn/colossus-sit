<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgControlVia
 *
 * @ORM\Table(name="sv_cfg_control_via")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgControlViaRepository")
 */
class SvCfgControlVia
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
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControl", inversedBy="controles")
     */
    private $tipoControl;

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
     * @return SvCfgControlVia
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
     * @return SvCfgControlVia
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
     * Set tipoControl
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControl $tipoControl
     *
     * @return SvCfgControlVia
     */
    public function setTipoControl(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControl $tipoControl = null)
    {
        $this->tipoControl = $tipoControl;

        return $this;
    }

    /**
     * Get tipoControl
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControl
     */
    public function getTipoControl()
    {
        return $this->tipoControl;
    }
}
