<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoCfgValor
 *
 * @ORM\Table(name="imo_cfg_valor")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoCfgValorRepository")
 */
class ImoCfgValor
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CasoInsumo", inversedBy="soats") */
    private $casoInsumo;


    /**
     * Get id
     *
     * @return integer
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
     * @return ImoCfgValor
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ImoCfgValor
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return ImoCfgValor
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
     * Set casoInsumo
     *
     * @param \AppBundle\Entity\CasoInsumo $casoInsumo
     *
     * @return ImoCfgValor
     */
    public function setCasoInsumo(\AppBundle\Entity\CasoInsumo $casoInsumo = null)
    {
        $this->casoInsumo = $casoInsumo;

        return $this;
    }

    /**
     * Get casoInsumo
     *
     * @return \AppBundle\Entity\CasoInsumo
     */
    public function getCasoInsumo()
    {
        return $this->casoInsumo;
    }
}
