<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvParametro
 *
 * @ORM\Table(name="msv_parametro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvParametroRepository")
 */
class MsvParametro
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
     * @ORM\Column(name="nombre", type="string", length=500)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_criterios", type="integer")
     */
    private $numeroCriterios;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvCategoria")
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
     * @return MsvParametro
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MsvParametro
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return MsvParametro
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set numeroCriterios
     *
     * @param integer $numeroCriterios
     *
     * @return MsvParametro
     */
    public function setNumeroCriterios($numeroCriterios)
    {
        $this->numeroCriterios = $numeroCriterios;

        return $this;
    }

    /**
     * Get numeroCriterios
     *
     * @return integer
     */
    public function getNumeroCriterios()
    {
        return $this->numeroCriterios;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\MsvCategoria $categoria
     *
     * @return MsvParametro
     */
    public function setCategoria(\AppBundle\Entity\MsvCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\MsvCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
