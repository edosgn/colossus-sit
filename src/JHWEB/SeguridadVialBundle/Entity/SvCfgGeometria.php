<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgGeometria
 *
 * @ORM\Table(name="sv_cfg_geometria")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgGeometriaRepository")
 */
class SvCfgGeometria
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
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoGeometria", inversedBy="tiposgeometria")
     */
    private $tipoGeometria;

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
     * @return SvCfgGeometria
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
     * @return SvCfgGeometria
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
     * Set tipoGeometria
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoGeometria $tipoGeometria
     *
     * @return SvCfgGeometria
     */
    public function setTipoGeometria(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoGeometria $tipoGeometria = null)
    {
        $this->tipoGeometria = $tipoGeometria;

        return $this;
    }

    /**
     * Get tipoGeometria
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoGeometria
     */
    public function getTipoGeometria()
    {
        return $this->tipoGeometria;
    }
}
