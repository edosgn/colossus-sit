<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialInventarioBodega
 *
 * @ORM\Table(name="sv_senial_inventario_bodega")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialInventarioBodegaRepository")
 */
class SvSenialInventarioBodega
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

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgSvSenialTipo", inversedBy="inventariosBodega") */
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
     * @return SvSenialInventarioBodega
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;
    }

    /**
     * Set consecutivo
     *
     * @param string $consecutivo
     *
     * @return SvSenialInventarioBodega
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
     * Set tipoSenial
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgSvSenialTipo $tipoSenial
     *
     * @return SvSenialInventarioBodega
     */
    public function setTipoSenial(\JHWEB\ConfigBundle\Entity\CfgSvSenialTipo $tipoSenial = null)
    {
        $this->tipoSenial = $tipoSenial;

        return $this;
    }

    /**
     * Get tipoSenial
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgSvSenialTipo
     */
    public function getTipoSenial()
    {
        return $this->tipoSenial;
    }
}
