<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvCriterio
 *
 * @ORM\Table(name="msv_criterio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvCriterioRepository")
 */
class MsvCriterio
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvVariable")
     **/
    protected $variable;


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
     * @return MsvCriterio
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
     * @return MsvCriterio
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

    /**
     * Set variable
     *
     * @param \AppBundle\Entity\MsvVariable $variable
     *
     * @return MsvVariable
     */
    public function setVariable(\AppBundle\Entity\MsvVariable $variable = null)
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Get variable
     *
     * @return \AppBundle\Entity\MsvVariable
     */
    public function getVariable()
    {
        return $this->variable;
    }
}

