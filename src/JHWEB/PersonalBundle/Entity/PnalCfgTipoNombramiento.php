<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalCfgTipoNombramiento
 *
 * @ORM\Table(name="pnal_cfg_tipo_nombramiento")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalCfgTipoNombramientoRepository")
 */
class PnalCfgTipoNombramiento
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
     * @var bool
     *
     * @ORM\Column(name="gestionable", type="boolean")
     */
    private $gestionable;

    /**
     * @var bool
     *
     * @ORM\Column(name="horarios", type="boolean")
     */
    private $horarios;

    /**
     * @var bool
     *
     * @ORM\Column(name="prorroga", type="boolean")
     */
    private $prorroga;

    /**
     * @var bool
     *
     * @ORM\Column(name="suspension", type="boolean")
     */
    private $suspension;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return PnalCfgTipoNombramiento
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
     * Set gestionable
     *
     * @param boolean $gestionable
     *
     * @return PnalCfgTipoNombramiento
     */
    public function setGestionable($gestionable)
    {
        $this->gestionable = $gestionable;

        return $this;
    }

    /**
     * Get gestionable
     *
     * @return boolean
     */
    public function getGestionable()
    {
        return $this->gestionable;
    }

    /**
     * Set horarios
     *
     * @param boolean $horarios
     *
     * @return PnalCfgTipoNombramiento
     */
    public function setHorarios($horarios)
    {
        $this->horarios = $horarios;

        return $this;
    }

    /**
     * Get horarios
     *
     * @return boolean
     */
    public function getHorarios()
    {
        return $this->horarios;
    }

    /**
     * Set prorroga
     *
     * @param boolean $prorroga
     *
     * @return PnalCfgTipoNombramiento
     */
    public function setProrroga($prorroga)
    {
        $this->prorroga = $prorroga;

        return $this;
    }

    /**
     * Get prorroga
     *
     * @return boolean
     */
    public function getProrroga()
    {
        return $this->prorroga;
    }

    /**
     * Set suspension
     *
     * @param boolean $suspension
     *
     * @return PnalCfgTipoNombramiento
     */
    public function setSuspension($suspension)
    {
        $this->suspension = $suspension;

        return $this;
    }

    /**
     * Get suspension
     *
     * @return boolean
     */
    public function getSuspension()
    {
        return $this->suspension;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalCfgTipoNombramiento
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
