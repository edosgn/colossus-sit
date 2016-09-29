<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Combustible
 *
 * @ORM\Table(name="combustible")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CombustibleRepository")
 */
class Combustible
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
     * @ORM\Column(name="nombreCombustible", type="string", length=255)
     */
    private $nombreCombustible;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoCombustible", type="integer", unique=true)
     */
    private $codigoCombustible;


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
     * Set nombreCombustible
     *
     * @param string $nombreCombustible
     *
     * @return Combustible
     */
    public function setNombreCombustible($nombreCombustible)
    {
        $this->nombreCombustible = $nombreCombustible;

        return $this;
    }

    /**
     * Get nombreCombustible
     *
     * @return string
     */
    public function getNombreCombustible()
    {
        return $this->nombreCombustible;
    }

    /**
     * Set codigoCombustible
     *
     * @param integer $codigoCombustible
     *
     * @return Combustible
     */
    public function setCodigoCombustible($codigoCombustible)
    {
        $this->codigoCombustible = $codigoCombustible;

        return $this;
    }

    /**
     * Get codigoCombustible
     *
     * @return int
     */
    public function getCodigoCombustible()
    {
        return $this->codigoCombustible;
    }
}

