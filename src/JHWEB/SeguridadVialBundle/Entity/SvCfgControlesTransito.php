<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgControlesTransito
 *
 * @ORM\Table(name="sv_cfg_controles_transito")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgControlesTransitoRepository")
 */
class SvCfgControlesTransito
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
     * @ORM\Column(name="nombre", type="string", nullable= true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito", inversedBy="tipos")
     */
    private $tipoControlTransito;

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
     * @return SvCfgControlesTransito
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
     * @return SvCfgControlesTransito
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
     * Set tipoControlTransito
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito $tipoControlTransito
     *
     * @return SvCfgControlesTransito
     */
    public function setTipoControlTransito(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito $tipoControlTransito = null)
    {
        $this->tipoControlTransito = $tipoControlTransito;

        return $this;
    }

    /**
     * Get tipoControlTransito
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoControlesTransito
     */
    public function getTipoControlTransito()
    {
        return $this->tipoControlTransito;
    }
}
