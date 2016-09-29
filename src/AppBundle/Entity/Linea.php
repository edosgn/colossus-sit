<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Linea
 *
 * @ORM\Table(name="linea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LineaRepository")
 */
class Linea
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
     * @ORM\Column(name="nombreLinea", type="string", length=255)
     */
    private $nombreLinea;


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
     * Set nombreLinea
     *
     * @param string $nombreLinea
     *
     * @return Linea
     */
    public function setNombreLinea($nombreLinea)
    {
        $this->nombreLinea = $nombreLinea;

        return $this;
    }

    /**
     * Get nombreLinea
     *
     * @return string
     */
    public function getNombreLinea()
    {
        return $this->nombreLinea;
    }
}

