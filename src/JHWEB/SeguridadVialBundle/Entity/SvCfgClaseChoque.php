<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgClaseChoque
 *
 * @ORM\Table(name="sv_cfg_clase_choque")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgClaseChoqueRepository")
 */
class SvCfgClaseChoque
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
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente", inversedBy="clasesaccidentes")
     */
    private $claseAccidente;

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
     * @return SvCfgClaseChoque
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
     * @return SvCfgClaseChoque
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
     * Set claseAccidente
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente
     *
     * @return SvCfgClaseChoque
     */
    public function setClaseAccidente(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente = null)
    {
        $this->claseAccidente = $claseAccidente;

        return $this;
    }

    /**
     * Get claseAccidente
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente
     */
    public function getClaseAccidente()
    {
        return $this->claseAccidente;
    }
}
