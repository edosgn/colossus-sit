<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvAuEstado
 *
 * @ORM\Table(name="cv_au_estado")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvAuEstadoRepository")
 */
class CvAuEstado
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
     * @var string
     *
     * @ORM\Column(name="cuerpo", type="text")
     */
    private $cuerpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="CvAuCfgTipo", inversedBy="estados") */
    private $tipo;

    /** @ORM\ManyToOne(targetEntity="CvAudiencia", inversedBy="estados") */
    private $audiencia;


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
     * @return CvAuEstado
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
     * Set cuerpo
     *
     * @param string $cuerpo
     *
     * @return CvAuEstado
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CvAuEstado
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvAuEstado
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
     * Set tipo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo $tipo
     *
     * @return CvAuEstado
     */
    public function setTipo(\JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set audiencia
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvAudiencia $audiencia
     *
     * @return CvAuEstado
     */
    public function setAudiencia(\JHWEB\ContravencionalBundle\Entity\CvAudiencia $audiencia = null)
    {
        $this->audiencia = $audiencia;

        return $this;
    }

    /**
     * Get audiencia
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvAudiencia
     */
    public function getAudiencia()
    {
        return $this->audiencia;
    }
}
