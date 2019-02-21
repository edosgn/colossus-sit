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
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=255)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=255)
     */
    private $municipio;

    /**
     * @var string
     *
     * @ORM\Column(name="jurisdiccion", type="string", length=10)
     */
    private $jurisdiccion;

    /**
     * @var bool
     *
     * @ORM\Column(name="asignacion_rango", type="boolean")
     */
    private $asignacionRango;

    /**
     * @var bool
     *
     * @ORM\Column(name="sede", type="boolean")
     */
    private $sede;

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
     * Set departamento
     *
     * @param string $departamento
     *
     * @return CfgOrganismoTransito
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return CfgOrganismoTransito
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set jurisdiccion
     *
     * @param string $jurisdiccion
     *
     * @return CfgOrganismoTransito
     */
    public function setJurisdiccion($jurisdiccion)
    {
        $this->jurisdiccion = $jurisdiccion;

        return $this;
    }

    /**
     * Get jurisdiccion
     *
     * @return string
     */
    public function getJurisdiccion()
    {
        return $this->jurisdiccion;
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
     * @return boolean
     */
    public function getAsignacionRango()
    {
        return $this->asignacionRango;
    }

    /**
     * Set sede
     *
     * @param boolean $sede
     *
     * @return CfgOrganismoTransito
     */
    public function setSede($sede)
    {
        $this->sede = $sede;

        return $this;
    }

    /**
     * Get sede
     *
     * @return boolean
     */
    public function getSede()
    {
        return $this->sede;
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
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
