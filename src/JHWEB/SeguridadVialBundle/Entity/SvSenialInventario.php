<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialInventario
 *
 * @ORM\Table(name="sv_senial_inventario")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialInventarioRepository")
 */
class SvSenialInventario
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="consecutivo", type="string", length=10)
     */
    private $consecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_destino", type="string", length=50)
     */
    private $tipoDestino;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inventarios") */
    private $municipio;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialTipo", inversedBy="inventarios") */
    private $tipoSenial;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvSenialInventario
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
        return $this->fecha;
    }

    /**
     * Set consecutivo
     *
     * @param string $consecutivo
     *
     * @return SvSenialInventario
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return string
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set tipoDestino
     *
     * @param string $tipoDestino
     *
     * @return SvSenialInventario
     */
    public function setTipoDestino($tipoDestino)
    {
        $this->tipoDestino = $tipoDestino;

        return $this;
    }

    /**
     * Get tipoDestino
     *
     * @return string
     */
    public function getTipoDestino()
    {
        return $this->tipoDestino;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return SvSenialInventario
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set tipoSenial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo $tipoSenial
     *
     * @return SvSenialInventario
     */
    public function setTipoSenial(\JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo $tipoSenial = null)
    {
        $this->tipoSenial = $tipoSenial;

        return $this;
    }

    /**
     * Get tipoSenial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSenialTipo
     */
    public function getTipoSenial()
    {
        return $this->tipoSenial;
    }
}
