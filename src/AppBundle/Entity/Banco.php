<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banco
 *
 * @ORM\Table(name="banco")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BancoRepository")
 */
class Banco
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
     * @ORM\Column(name="nombreBanco", type="string", length=255)
     */
    private $nombreBanco;


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
     * Set nombreBanco
     *
     * @param string $nombreBanco
     *
     * @return Banco
     */
    public function setNombreBanco($nombreBanco)
    {
        $this->nombreBanco = $nombreBanco;

        return $this;
    }

    /**
     * Get nombreBanco
     *
     * @return string
     */
    public function getNombreBanco()
    {
        return $this->nombreBanco;
    }
}

