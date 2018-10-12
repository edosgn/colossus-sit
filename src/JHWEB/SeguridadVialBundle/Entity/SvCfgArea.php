<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgArea
 *
 * @ORM\Table(name="sv_cfg_area")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgAreaRepository")
 */
class SvCfgArea
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
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoArea", inversedBy="tipos")
     **/
    protected $tipoArea;

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
     * @return SvCfgArea
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
     * @return SvCfgArea
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
     * @return SvCfgArea
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
