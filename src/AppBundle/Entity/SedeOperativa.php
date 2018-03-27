<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SedeOperativa
 *
 * @ORM\Table(name="sede_operativa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SedeOperativaRepository")
 */
class SedeOperativa
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
     * @ORM\Column(name="codigo_divipo", type="string", length=50)
     */
    private $codigoDivipo;

    /**
     * @var bool
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return SedeOperativa
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
     * Set codigoDivipo
     *
     * @param string $codigoDivipo
     *
     * @return SedeOperativa
     */
    public function setCodigoDivipo($codigoDivipo)
    {
        $this->codigoDivipo = $codigoDivipo;

        return $this;
    }

    /**
     * Get codigoDivipo
     *
     * @return string
     */
    public function getCodigoDivipo()
    {
        return $this->codigoDivipo;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return SedeOperativa
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }
}

