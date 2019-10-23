<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgParametro
 *
 * @ORM\Table(name="sv_cfg_parametro")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgParametroRepository")
 */
class SvCfgParametro
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
     * @ORM\ManyToOne(targetEntity="SvCfgCategoria")
     **/
    protected $categoria;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

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
     * @return SvCfgParametro
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return SvCfgParametro
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
     * @return SvCfgParametro
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCfgParametro
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
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCategoria $categoria
     *
     * @return SvCfgParametro
     */
    public function setCategoria(\JHWEB\SeguridadVialBundle\Entity\SvCfgCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
