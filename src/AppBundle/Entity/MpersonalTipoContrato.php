<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpersonalTipoContrato
 *
 * @ORM\Table(name="mpersonal_tipo_contrato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MpersonalTipoContratoRepository")
 */
class MpersonalTipoContrato
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Get id
     *
     * @return integer
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
     * @return MpersonalTipoContrato
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
     * @return MpersonalTipoContrato
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
     * Set horarios
     *
     * @param boolean $horarios
     *
     * @return MpersonalTipoContrato
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
     * @return MpersonalTipoContrato
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
}
