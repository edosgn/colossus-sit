<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgSubpartidaArancelaria
 *
 * @ORM\Table(name="vhlo_cfg_subpartida_arancelaria")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgSubpartidaArancelariaRepository")
 */
class VhloCfgSubpartidaArancelaria
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
     * @ORM\Column(name="valor", type="string", length=255)
     */
    private $valor;

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
     * Set valor
     *
     * @param string $valor
     *
     * @return VhloCfgSubpartidaArancelaria
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return VhloCfgSubpartidaArancelaria
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
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
     * @return VhloCfgSubpartidaArancelaria
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
