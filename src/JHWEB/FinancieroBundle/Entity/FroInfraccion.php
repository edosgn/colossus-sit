<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroInfraccion
 *
 * @ORM\Table(name="fro_infraccion")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroInfraccionRepository")
 */
class FroInfraccion
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
     * @ORM\Column(name="suspende", type="boolean")
     */
    private $suspende;

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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="FroInfrCfgCategoria", inversedBy="infracciones")
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
     * @return FroInfraccion
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
     * @return FroInfraccion
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
     * @return FroInfraccion
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
     * Set suspende
     *
     * @param boolean $suspende
     *
     * @return FroInfraccion
     */
    public function setSuspende($suspende)
    {
        $this->suspende = $suspende;

        return $this;
    }

    /**
     * Get suspende
     *
     * @return boolean
     */
    public function getSuspende()
    {
        return $this->suspende;
    }

    /**
     * Set inmoviliza
     *
     * @param boolean $inmoviliza
     *
     * @return FroInfraccion
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
     * @return FroInfraccion
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroInfraccion
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
     * Set categoria
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroInfrCfgCategoria $categoria
     *
     * @return FroInfraccion
     */
    public function setCategoria(\JHWEB\FinancieroBundle\Entity\FroInfrCfgCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroInfrCfgCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
