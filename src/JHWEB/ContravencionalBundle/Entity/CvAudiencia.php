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
     * @ORM\Column(name="acta", type="text", nullable=true)
     */
    private $acta;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="cuerpo", type="text", nullable=true)
     */
    private $cuerpo;

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

    /** @ORM\ManyToOne(targetEntity="CvCdoComparendo", inversedBy="audiencias") */
    private $comparendo;

    /** @ORM\ManyToOne(targetEntity="CvAuCfgTipo", inversedBy="audiencias") */
    private $tipo;


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
     * Set acta
     *
     * @param string $acta
     *
     * @return CvAudiencia
     */
    public function setActa($acta)
    {
        $this->acta = $acta;

        return $this;
    }

    /**
     * Get acta
     *
     * @return string
     */
    public function getActa()
    {
        return $this->acta;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return CvAudiencia
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     *
     * @return CvAudiencia
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
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo
     *
     * @return CvAudiencia
     */
    public function setComparendo(\JHWEB\ContravencionalBundle\Entity\CvCdoComparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoComparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set tipo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo $tipo
     *
     * @return CvAudiencia
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
}
