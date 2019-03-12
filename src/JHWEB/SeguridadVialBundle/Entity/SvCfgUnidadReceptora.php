<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgUnidadReceptora
 *
 * @ORM\Table(name="sv_cfg_unidad_receptora")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgUnidadReceptoraRepository")
 */
class SvCfgUnidadReceptora
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
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer", nullable= true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable= true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente", inversedBy="unidadesReceptoras")
     */
    private $entidadAccidente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="unidadesReceptoras")
     */
    private $municipio;

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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return SvCfgUnidadReceptora
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return SvCfgUnidadReceptora
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
     * @return SvCfgUnidadReceptora
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
     * Set entidadAccidente
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadAccidente
     *
     * @return SvCfgUnidadReceptora
     */
    public function setEntidadAccidente(\JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadAccidente = null)
    {
        $this->entidadAccidente = $entidadAccidente;

        return $this;
    }

    /**
     * Get entidadAccidente
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente
     */
    public function getEntidadAccidente()
    {
        return $this->entidadAccidente;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return SvCfgUnidadReceptora
     */
    public function setMunicipio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
