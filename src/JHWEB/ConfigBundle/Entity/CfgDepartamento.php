<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgDepartamento
 *
 * @ORM\Table(name="cfg_departamento")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgDepartamentoRepository")
 */
class CfgDepartamento
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
     * @ORM\ManyToOne(targetEntity="CfgPais", inversedBy="departamentos")
     */
    private $pais;


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
     * @return CfgDepartamento
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
     * @return CfgDepartamento
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
     * @return CfgDepartamento
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
     * Set pais
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgPais $pais
     *
     * @return CfgDepartamento
     */
    public function setPais(\JHWEB\ConfigBundle\Entity\CfgPais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgPais
     */
    public function getPais()
    {
        return $this->pais;
    }
}
