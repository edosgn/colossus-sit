<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialInventarioMunicipio
 *
 * @ORM\Table(name="sv_senial_inventario_municipio")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialInventarioMunicipioRepository")
 */
class SvSenialInventarioMunicipio
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

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgSvSenialTipo", inversedBy="inventariosMunicipio") */
    private $tipoSenial;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inventariosMunicipio") */
    private $municipio;


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
     * @return SvSenialInventarioMunicipio
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
     * @return SvSenialInventarioMunicipio
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
     * @return SvSenialInventarioMunicipio
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

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return SvSenialInventarioMunicipio
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
}
