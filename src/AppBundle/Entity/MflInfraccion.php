<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MflInfraccion
 *
 * @ORM\Table(name="mfl_infraccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MflInfraccionRepository")
 */
class MflInfraccion
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="retiene", type="boolean")
     */
    private $retiene;

    /**
     * @var bool
     *
     * @ORM\Column(name="inmoviliza", type="boolean")
     */
    private $inmoviliza;

    /**
     * @var int
     *
     * @ORM\Column(name="dias", type="integer", nullable=true)
     */
    private $dias;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MflInfraccionCategoria", inversedBy="infracciones")
     **/
    protected $categoria;


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
     * @return MflInfraccion
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return MflInfraccion
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return MflInfraccion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MflInfraccion
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
     * Set retiene
     *
     * @param boolean $retiene
     *
     * @return MflInfraccion
     */
    public function setRetiene($retiene)
    {
        $this->retiene = $retiene;

        return $this;
    }

    /**
     * Get retiene
     *
     * @return boolean
     */
    public function getRetiene()
    {
        return $this->retiene;
    }

    /**
     * Set inmoviliza
     *
     * @param boolean $inmoviliza
     *
     * @return MflInfraccion
     */
    public function setInmoviliza($inmoviliza)
    {
        $this->inmoviliza = $inmoviliza;

        return $this;
    }

    /**
     * Get inmoviliza
     *
     * @return boolean
     */
    public function getInmoviliza()
    {
        return $this->inmoviliza;
    }

    /**
     * Set dias
     *
     * @param integer $dias
     *
     * @return MflInfraccion
     */
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    /**
     * Get dias
     *
     * @return integer
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\MflInfraccionCategoria $categoria
     *
     * @return MflInfraccion
     */
    public function setCategoria(\AppBundle\Entity\MflInfraccionCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\MflInfraccionCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
