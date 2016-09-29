<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumibles
 *
 * @ORM\Table(name="consumibles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsumiblesRepository")
 */
class Consumible
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
     * @ORM\Column(name="nombreConsumible", type="string", length=255)
     */
    private $nombreConsumible;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Almacen", mappedBy="consumible")
     */
    protected $almacenes; 

    public function __construct() {
        $this->almacenes = new \Doctrine\Common\Collections\ArrayCollection();
        
    }


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
     * Set nombreConsumible
     *
     * @param string $nombreConsumible
     *
     * @return Consumibles
     */
    public function setNombreConsumible($nombreConsumible)
    {
        $this->nombreConsumible = $nombreConsumible;

        return $this;
    }

    /**
     * Get nombreConsumible
     *
     * @return string
     */
    public function getNombreConsumible()
    {
        return $this->nombreConsumible;
    }

    /**
     * Add almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     *
     * @return Consumible
     */
    public function addAlmacene(\AppBundle\Entity\Almacen $almacene)
    {
        $this->almacenes[] = $almacene;

        return $this;
    }

    /**
     * Remove almacene
     *
     * @param \AppBundle\Entity\Almacen $almacene
     */
    public function removeAlmacene(\AppBundle\Entity\Almacen $almacene)
    {
        $this->almacenes->removeElement($almacene);
    }

    /**
     * Get almacenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlmacenes()
    {
        return $this->almacenes;
    }
}
