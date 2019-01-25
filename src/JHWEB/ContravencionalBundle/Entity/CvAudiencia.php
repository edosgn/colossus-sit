<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvAudiencia
 *
 * @ORM\Table(name="cv_audiencia")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvAudienciaRepository")
 */
class CvAudiencia
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
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivo", type="text")
     */
    private $objetivo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="apoderado", type="string", length=255)
     */
    private $apoderado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="audicencias") */
    private $comparendo;


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
     * @return CvAudiencia
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CvAudiencia
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
     * Set objetivo
     *
     * @param string $objetivo
     *
     * @return CvAudiencia
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvAudiencia
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
     * Set apoderado
     *
     * @param string $apoderado
     *
     * @return CvAudiencia
     */
    public function setApoderado($apoderado)
    {
        $this->apoderado = $apoderado;

        return $this;
    }

    /**
     * Get apoderado
     *
     * @return string
     */
    public function getApoderado()
    {
        return $this->apoderado;
    }

    /**
     * Set comparendo
     *
     * @param \AppBundle\Entity\Comparendo $comparendo
     *
     * @return CvAudiencia
     */
    public function setComparendo(\AppBundle\Entity\Comparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \AppBundle\Entity\Comparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }
}
