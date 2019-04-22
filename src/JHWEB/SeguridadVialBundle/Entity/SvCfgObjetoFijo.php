<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgObjetoFijo
 *
 * @ORM\Table(name="sv_cfg_objeto_fijo")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgObjetoFijoRepository")
 */
class SvCfgObjetoFijo
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
     * @ORM\ManyToOne(targetEntity="SvCfgClaseChoque", inversedBy="claseschoques")
     */
    private $claseChoque;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable= true)
     */
    private $nombre;

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
     * @return SvCfgObjetoFijo
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
     * @return SvCfgObjetoFijo
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
     * Set claseChoque
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque $claseChoque
     *
     * @return SvCfgObjetoFijo
     */
    public function setClaseChoque(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque $claseChoque = null)
    {
        $this->claseChoque = $claseChoque;

        return $this;
    }

    /**
     * Get claseChoque
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseChoque
     */
    public function getClaseChoque()
    {
        return $this->claseChoque;
    }
}
