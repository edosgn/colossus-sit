<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caso_Tramite
 *
 * @ORM\Table(name="caso__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Caso_TramiteRepository")
 */
class Caso_Tramite
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
     * @ORM\Column(name="nombreCaso", type="string", length=255)
     */
    private $nombreCaso;


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
     * Set nombreCaso
     *
     * @param string $nombreCaso
     *
     * @return Caso_Tramite
     */
    public function setNombreCaso($nombreCaso)
    {
        $this->nombreCaso = $nombreCaso;

        return $this;
    }

    /**
     * Get nombreCaso
     *
     * @return string
     */
    public function getNombreCaso()
    {
        return $this->nombreCaso;
    }
}

