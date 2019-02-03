<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgOrganismoTransito
 *
 * @ORM\Table(name="cfg_organismo_transito")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgOrganismoTransitoRepository")
 */
class CfgOrganismoTransito
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
     * @var int
     *
     * @ORM\Column(name="divipo", type="integer")
     */
    private $divipo;

    /**
     * @var bool
     *
     * @ORM\Column(name="asignacion_rango", type="boolean")
     */
    private $asignacionRango;

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
     * @return CfgOrganismoTransito
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
     * Set divipo
     *
     * @param integer $divipo
     *
     * @return CfgOrganismoTransito
     */
    public function setDivipo($divipo)
    {
        $this->divipo = $divipo;

        return $this;
    }

    /**
     * Get divipo
     *
     * @return int
     */
    public function getDivipo()
    {
        return $this->divipo;
    }

    /**
     * Set asignacionRango
     *
     * @param boolean $asignacionRango
     *
     * @return CfgOrganismoTransito
     */
    public function setAsignacionRango($asignacionRango)
    {
        $this->asignacionRango = $asignacionRango;

        return $this;
    }

    /**
     * Get asignacionRango
     *
     * @return bool
     */
    public function getAsignacionRango()
    {
        return $this->asignacionRango;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgOrganismoTransito
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }
}

