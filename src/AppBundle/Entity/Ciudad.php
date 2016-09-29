<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table(name="ciudad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadRepository")
 */
class Ciudad
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
     * @ORM\Column(name="nombreCiudad", type="string", length=255)
     */
    private $nombreCiudad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCiudad", type="string", length=255)
     */
    private $codigoCiudad;


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
     * Set nombreCiudad
     *
     * @param string $nombreCiudad
     *
     * @return Ciudad
     */
    public function setNombreCiudad($nombreCiudad)
    {
        $this->nombreCiudad = $nombreCiudad;

        return $this;
    }

    /**
     * Get nombreCiudad
     *
     * @return string
     */
    public function getNombreCiudad()
    {
        return $this->nombreCiudad;
    }

    /**
     * Set codigoCiudad
     *
     * @param string $codigoCiudad
     *
     * @return Ciudad
     */
    public function setCodigoCiudad($codigoCiudad)
    {
        $this->codigoCiudad = $codigoCiudad;

        return $this;
    }

    /**
     * Get codigoCiudad
     *
     * @return string
     */
    public function getCodigoCiudad()
    {
        return $this->codigoCiudad;
    }
}

