<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgClaseMaquinaria
 *
 * @ORM\Table(name="vhlo_cfg_clase_maquinaria")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgClaseMaquinariaRepository")
 */
class VhloCfgClaseMaquinaria
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
     * @ORM\Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="VhloCfgTipoMaquinaria", inversedBy="clases") */
    private $tipoMaquinaria;


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
     * @return VhloCfgClaseMaquinaria
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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return VhloCfgClaseMaquinaria
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloCfgClaseMaquinaria
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
     * Set tipoMaquinaria
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria $tipoMaquinaria
     *
     * @return VhloCfgClaseMaquinaria
     */
    public function setTipoMaquinaria(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria $tipoMaquinaria = null)
    {
        $this->tipoMaquinaria = $tipoMaquinaria;

        return $this;
    }

    /**
     * Get tipoMaquinaria
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoMaquinaria
     */
    public function getTipoMaquinaria()
    {
        return $this->tipoMaquinaria;
    }
}
