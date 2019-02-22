<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalCfgTipoContrato
 *
 * @ORM\Table(name="pnal_cfg_tipo_contrato")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalCfgTipoContratoRepository")
 */
class PnalCfgTipoContrato
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
     * @return PnalCfgTipoContrato
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
     * Set horarios
     *
     * @param boolean $horarios
     *
     * @return PnalCfgTipoContrato
     */
    public function setHorarios($horarios)
    {
        $this->horarios = $horarios;

        return $this;
    }

    /**
     * Get horarios
     *
     * @return bool
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
     * @return PnalCfgTipoContrato
     */
    public function setProrroga($prorroga)
    {
        $this->prorroga = $prorroga;

        return $this;
    }

    /**
     * Get prorroga
     *
     * @return bool
     */
    public function getProrroga()
    {
        return $this->prorroga;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalCfgTipoContrato
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
}

