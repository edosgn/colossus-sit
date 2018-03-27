<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguimientoEntrega
 *
 * @ORM\Table(name="seguimiento_entrega")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeguimientoEntregaRepository")
 */
class SeguimientoEntrega
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
     * @ORM\Column(name="numeroRegistros", type="string", length=255)
     */
    private $numeroRegistros;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroOficio", type="string", length=255)
     */
    private $numeroOficio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCargue", type="date")
     */
    private $fechaCargue;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


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
     * @return SeguimientoEntrega
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
     * @return SeguimientoEntrega
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
     * @return SeguimientoEntrega
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return SeguimientoEntrega
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
