<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Variante_Tramite
 *
 * @ORM\Table(name="variante__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Variante_TramiteRepository")
 */
class Variante_Tramite
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
     * @ORM\Column(name="descripcionVariante", type="string", length=255)
     */
    private $descripcionVariante;


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
     * Set descripcionVariante
     *
     * @param string $descripcionVariante
     *
     * @return Variante_Tramite
     */
    public function setDescripcionVariante($descripcionVariante)
    {
        $this->descripcionVariante = $descripcionVariante;

        return $this;
    }

    /**
     * Get descripcionVariante
     *
     * @return string
     */
    public function getDescripcionVariante()
    {
        return $this->descripcionVariante;
    }
}

