<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgVariable
 *
 * @ORM\Table(name="sv_cfg_variable")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgVariableRepository")
 */
class SvCfgVariable
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
     * @ORM\ManyToOne(targetEntity="SvCfgParametro", inversedBy="variables")
     **/
    protected $parametro;

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
     * @return SvCfgVariable
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
     * @return SvCfgVariable
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
     * Set parametro
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgParametro $parametro
     *
     * @return SvCfgVariable
     */
    public function setParametro(\JHWEB\SeguridadVialBundle\Entity\SvCfgParametro $parametro = null)
    {
        $this->parametro = $parametro;

        return $this;
    }

    /**
     * Get parametro
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgParametro
     */
    public function getParametro()
    {
        return $this->parametro;
    }
}
