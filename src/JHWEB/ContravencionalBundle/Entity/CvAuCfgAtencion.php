<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvAuCfgAtencion
 *
 * @ORM\Table(name="cv_au_cfg_atencion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvAuCfgAtencionRepository")
 */
class CvAuCfgAtencion
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
     * @ORM\Column(name="hora_maniana_inicial", type="time")
     */
    private $horaManianaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_maniana_final", type="time")
     */
    private $horaManianaFinal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_tarde_inicial", type="time")
     */
    private $horaTardeInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_tarde_final", type="time")
     */
    private $horaTardeFinal;

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
     * Set dia
     *
     * @param integer $dia
     *
     * @return CvAuCfgAtencion
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set horaManianaInicial
     *
     * @param \DateTime $horaManianaInicial
     *
     * @return CvAuCfgAtencion
     */
    public function setHoraManianaInicial($horaManianaInicial)
    {
        $this->horaManianaInicial = $horaManianaInicial;

        return $this;
    }

    /**
     * Get horaManianaInicial
     *
     * @return \DateTime
     */
    public function getHoraManianaInicial()
    {
        return $this->horaManianaInicial;
    }

    /**
     * Set horaManianaFinal
     *
     * @param \DateTime $horaManianaFinal
     *
     * @return CvAuCfgAtencion
     */
    public function setHoraManianaFinal($horaManianaFinal)
    {
        $this->horaManianaFinal = $horaManianaFinal;

        return $this;
    }

    /**
     * Get horaManianaFinal
     *
     * @return \DateTime
     */
    public function getHoraManianaFinal()
    {
        return $this->horaManianaFinal;
    }

    /**
     * Set horaTardeInicial
     *
     * @param \DateTime $horaTardeInicial
     *
     * @return CvAuCfgAtencion
     */
    public function setHoraTardeInicial($horaTardeInicial)
    {
        $this->horaTardeInicial = $horaTardeInicial;

        return $this;
    }

    /**
     * Get horaTardeInicial
     *
     * @return \DateTime
     */
    public function getHoraTardeInicial()
    {
        return $this->horaTardeInicial;
    }

    /**
     * Set horaTardeFinal
     *
     * @param \DateTime $horaTardeFinal
     *
     * @return CvAuCfgAtencion
     */
    public function setHoraTardeFinal($horaTardeFinal)
    {
        $this->horaTardeFinal = $horaTardeFinal;

        return $this;
    }

    /**
     * Get horaTardeFinal
     *
     * @return \DateTime
     */
    public function getHoraTardeFinal()
    {
        return $this->horaTardeFinal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvAuCfgAtencion
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
