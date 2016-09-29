<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Color
 *
 * @ORM\Table(name="color")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColorRepository")
 */
class Color
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
     * @ORM\Column(name="nombreColor", type="string", length=255)
     */
    private $nombreColor;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoColor", type="integer", unique=true)
     */
    private $codigoColor;


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
     * Set nombreColor
     *
     * @param string $nombreColor
     *
     * @return Color
     */
    public function setNombreColor($nombreColor)
    {
        $this->nombreColor = $nombreColor;

        return $this;
    }

    /**
     * Get nombreColor
     *
     * @return string
     */
    public function getNombreColor()
    {
        return $this->nombreColor;
    }

    /**
     * Set codigoColor
     *
     * @param integer $codigoColor
     *
     * @return Color
     */
    public function setCodigoColor($codigoColor)
    {
        $this->codigoColor = $codigoColor;

        return $this;
    }

    /**
     * Get codigoColor
     *
     * @return int
     */
    public function getCodigoColor()
    {
        return $this->codigoColor;
    }
}

