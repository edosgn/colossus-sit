<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoSeguimientoEntrega
 *
 * @ORM\Table(name="cv_cdo_seguimiento_entrega")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoSeguimientoEntregaRepository")
 */
class CvCdoSeguimientoEntrega
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
     * @ORM\Column(name="numero_registros", type="string", length=255)
     */
    private $numeroRegistros;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_oficio", type="string", length=255)
     */
    private $numeroOficio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cargue", type="date")
     */
    private $fechaCargue;

    /**
     * @var boolean
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
     * Set numeroRegistros
     *
     * @param string $numeroRegistros
     *
     * @return CvCdoSeguimientoEntrega
     */
    public function setNumeroRegistros($numeroRegistros)
    {
        $this->numeroRegistros = $numeroRegistros;

        return $this;
    }

    /**
     * Get numeroRegistros
     *
     * @return string
     */
    public function getNumeroRegistros()
    {
        return $this->numeroRegistros;
    }

    /**
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return CvCdoSeguimientoEntrega
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return string
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
    }

    /**
     * Set fechaCargue
     *
     * @param \DateTime $fechaCargue
     *
     * @return CvCdoSeguimientoEntrega
     */
    public function setFechaCargue($fechaCargue)
    {
        $this->fechaCargue = $fechaCargue;

        return $this;
    }

    /**
     * Get fechaCargue
     *
     * @return \DateTime
     */
    public function getFechaCargue()
    {
        return $this->fechaCargue;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoSeguimientoEntrega
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
