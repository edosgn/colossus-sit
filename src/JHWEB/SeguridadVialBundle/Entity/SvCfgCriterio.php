<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgCriterio
 *
 * @ORM\Table(name="sv_cfg_criterio")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgCriterioRepository")
 */
class SvCfgCriterio
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
     * @ORM\Column(name="nombre", type="string", length=500)
     */
    private $nombre;
    
    /**
     * @ORM\ManyToOne(targetEntity="SvCfgVariable")
     **/
    protected $variable;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

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
     * @return SvCfgCriterio
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
     * @return SvCfgCriterio
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
     * Set variable
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgVariable $variable
     *
     * @return SvCfgCriterio
     */
    public function setVariable(\JHWEB\SeguridadVialBundle\Entity\SvCfgVariable $variable = null)
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Get variable
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgVariable
     */
    public function getVariable()
    {
        return $this->variable;
    }
}
