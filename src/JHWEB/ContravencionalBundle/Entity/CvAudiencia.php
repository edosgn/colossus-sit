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
     * @ORM\Column(name="borrador", type="text", nullable=true)
     */
    private $borrador;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=50, nullable=true)
     */
    private $tipo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="apoderado", type="string", length=255, nullable=true)
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
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
        if ($this->hora) {
            return $this->hora->format('h:i:s A');
        }
        return $this->hora;
    }

    /**
     * Set borrador
     *
     * @param string $borrador
     *
     * @return CvAudiencia
     */
    public function setBorrador($borrador)
    {
        $this->borrador = $borrador;

        return $this;
    }

    /**
     * Get borrador
     *
     * @return string
     */
    public function getBorrador()
    {
        return $this->borrador;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return CvAudiencia
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
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
