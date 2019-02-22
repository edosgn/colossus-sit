<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroInfrCfgCategoria
 *
 * @ORM\Table(name="fro_infr_cfg_categoria")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroInfrCfgCategoriaRepository")
 */
class FroInfrCfgCategoria
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="smldv", type="integer")
     */
    private $smldv;

    /**
     * @var bool
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FroInfrCfgCategoria
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return FroInfrCfgCategoria
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
     * Set smldv
     *
     * @param integer $smldv
     *
     * @return FroInfrCfgCategoria
     */
    public function setSmldv($smldv)
    {
        $this->smldv = $smldv;

        return $this;
    }

    /**
     * Get smldv
     *
     * @return integer
     */
    public function getSmldv()
    {
        return $this->smldv;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroInfrCfgCategoria
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
