<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="marca")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarcaRepository")
 */
class Marca
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
     * @ORM\Column(name="nombreMarca", type="string", length=255)
     */
    private $nombreMarca;


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
     * Set nombreMarca
     *
     * @param string $nombreMarca
     *
     * @return Marca
     */
    public function setNombreMarca($nombreMarca)
    {
        $this->nombreMarca = $nombreMarca;

        return $this;
    }

    /**
     * Get nombreMarca
     *
     * @return string
     */
    public function getNombreMarca()
    {
        return $this->nombreMarca;
    }
}

