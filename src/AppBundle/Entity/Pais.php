<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaisRepository")
 */
class Pais
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
     * @ORM\Column(name="nombrePais", type="string", length=45)
     */
    private $nombrePais;

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
     * Set nombrePais
     *
     * @param string $nombrePais
     *
     * @return Pais
     */
    public function setNombrePais($nombrePais)
    {
        $this->nombrePais = $nombrePais;

        return $this;
    }

    /**
     * Get nombrePais
     *
     * @return string
     */
    public function getNombrePais()
    {
        return $this->nombrePais;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Pais
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
