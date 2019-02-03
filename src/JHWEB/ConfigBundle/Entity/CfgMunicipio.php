<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgMunicipio
 *
 * @ORM\Table(name="cfg_municipio")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgMunicipioRepository")
 */
class CfgMunicipio
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
     * @ORM\Column(name="codigo_dane", type="integer")
     */
    private $codigoDane;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="CfgDepartamento", inversedBy="municipios")
     */
    private $departamento;


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
     * @return CfgMunicipio
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
     * Set codigoDane
     *
     * @param integer $codigoDane
     *
     * @return CfgMunicipio
     */
    public function setCodigoDane($codigoDane)
    {
        $this->codigoDane = $codigoDane;

        return $this;
    }

    /**
     * Get codigoDane
     *
     * @return int
     */
    public function getCodigoDane()
    {
        return $this->codigoDane;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgMunicipio
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

    /**
     * Set departamento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgDepartamento $departamento
     *
     * @return CfgMunicipio
     */
    public function setDepartamento(\JHWEB\ConfigBundle\Entity\CfgDepartamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgDepartamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }
}
