<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgFuncionCriterio
 *
 * @ORM\Table(name="sv_cfg_funcion_criterio")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgFuncionCriterioRepository")
 */
class SvCfgFuncionCriterio
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="SvCfgFuncion", inversedBy="funciones")
     */
    private $funcion;

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
     * @return SvCfgFuncionCriterio
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
     * @return SvCfgFuncionCriterio
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
     * Set funcion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion $funcion
     *
     * @return SvCfgFuncionCriterio
     */
    public function setFuncion(\JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion $funcion = null)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion
     */
    public function getFuncion()
    {
        return $this->funcion;
    }
}
