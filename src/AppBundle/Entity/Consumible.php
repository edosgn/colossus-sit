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
}

