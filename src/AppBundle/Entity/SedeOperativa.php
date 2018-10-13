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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inmovilizaciones")
     **/
    protected $municipio;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="asignacion_rango", type="boolean")
     */
    private $asignacionRango;


    

    /**
     * Get id
     *
     * @return integer
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
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set asignacionRango
     *
     * @param boolean $asignacionRango
     *
     * @return SedeOperativa
     */
    public function setAsignacionRango($asignacionRango)
    {
        $this->asignacionRango = $asignacionRango;

        return $this;
    }

    /**
     * Get asignacionRango
     *
     * @return boolean
     */
    public function getAsignacionRango()
    {
        return $this->asignacionRango;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return SedeOperativa
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
