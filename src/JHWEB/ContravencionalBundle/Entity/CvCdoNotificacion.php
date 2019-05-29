<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoNotificacion
 *
 * @ORM\Table(name="cv_cdo_notificacion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoNotificacionRepository")
 */
class CvCdoNotificacion
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

    /** @ORM\ManyToOne(targetEntity="JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado", inversedBy="notificaciones") */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalCfgCargo", inversedBy="notificaciones") */
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
     * @return CvCdoNotificacion
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
     * @return CvCdoNotificacion
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
        if ($this->hora) {
            return $this->hora->format('h:m:s A');
        }
        return $this->hora;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoNotificacion
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
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado
     *
     * @return CvCdoNotificacion
     */
    public function setEstado(\JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cargo
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgCargo $cargo
     *
     * @return CvCdoNotificacion
     */
    public function setCargo(\JHWEB\PersonalBundle\Entity\PnalCfgCargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalCfgCargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}
