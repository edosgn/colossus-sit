<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Infraccion
 *
 * @ORM\Table(name="infraccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfraccionRepository")
 */
class Infraccion
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
     * @ORM\Column(name="codigoInfraccion", type="string", length=45)
     */
    private $codigoInfraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionInfraccion", type="string", length=255)
     */
    private $descripcionInfraccion;

    /**
     * @var float
     *
     * @ORM\Column(name="valorInfraccion", type="float")
     */
    private $valorInfraccion;


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
     * Set codigoInfraccion
     *
     * @param string $codigoInfraccion
     *
     * @return Infraccion
     */
    public function setCodigoInfraccion($codigoInfraccion)
    {
        $this->codigoInfraccion = $codigoInfraccion;

        return $this;
    }

    /**
     * Get codigoInfraccion
     *
     * @return string
     */
    public function getCodigoInfraccion()
    {
        return $this->codigoInfraccion;
    }

    /**
     * Set descripcionInfraccion
     *
     * @param string $descripcionInfraccion
     *
     * @return Infraccion
     */
    public function setDescripcionInfraccion($descripcionInfraccion)
    {
        $this->descripcionInfraccion = $descripcionInfraccion;

        return $this;
    }

    /**
     * Get descripcionInfraccion
     *
     * @return string
     */
    public function getDescripcionInfraccion()
    {
        return $this->descripcionInfraccion;
    }

    /**
     * Set valorInfraccion
     *
     * @param float $valorInfraccion
     *
     * @return Infraccion
     */
    public function setValorInfraccion($valorInfraccion)
    {
        $this->valorInfraccion = $valorInfraccion;

        return $this;
    }

    /**
     * Get valorInfraccion
     *
     * @return float
     */
    public function getValorInfraccion()
    {
        return $this->valorInfraccion;
    }
}
