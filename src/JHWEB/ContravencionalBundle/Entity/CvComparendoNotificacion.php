<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvComparendoNotificacion
 *
 * @ORM\Table(name="cv_comparendo_notificacion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvComparendoNotificacionRepository")
 */
class CvComparendoNotificacion
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
     * @var int
     *
     * @ORM\Column(name="dia", type="integer")
     */
    private $dia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgComparendoEstado", inversedBy="notificaciones") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgCargo", inversedBy="notificaciones") */
    private $cargo;


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
     * Set dia
     *
     * @param integer $dia
     *
     * @return CvComparendoNotificacion
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return int
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CvComparendoNotificacion
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvComparendoNotificacion
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
     * Set estado
     *
     * @param \AppBundle\Entity\CfgComparendoEstado $estado
     *
     * @return CvComparendoNotificacion
     */
    public function setEstado(\AppBundle\Entity\CfgComparendoEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\CfgComparendoEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cargo
     *
     * @param \AppBundle\Entity\CfgCargo $cargo
     *
     * @return CvComparendoNotificacion
     */
    public function setCargo(\AppBundle\Entity\CfgCargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \AppBundle\Entity\CfgCargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}
