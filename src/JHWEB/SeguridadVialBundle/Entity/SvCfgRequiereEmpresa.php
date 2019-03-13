<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgRequiereEmpresa
 *
 * @ORM\Table(name="sv_cfg_requiere_empresa")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgRequiereEmpresaRepository")
 */
class SvCfgRequiereEmpresa
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
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria", inversedBy="requiereEmpresa")
     */
    private $carroceria;

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
     * @return SvCfgRequiereEmpresa
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
     * @return SvCfgRequiereEmpresa
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
     * Set carroceria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria $carroceria
     *
     * @return SvCfgRequiereEmpresa
     */
    public function setCarroceria(\JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria $carroceria = null)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgCarroceria
     */
    public function getCarroceria()
    {
        return $this->carroceria;
    }
}
