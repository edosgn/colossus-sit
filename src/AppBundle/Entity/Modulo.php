<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuloRepository")
 */
class Modulo
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviatura", type="string", length=255)
     */
    private $abreviatura;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tramite", mappedBy="modulo")
     */
    protected $tramites;  

    public function __construct() {
        $this->tramites = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Modulo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Modulo
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Add tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return Modulo
     */
    public function addTramite(\AppBundle\Entity\Tramite $tramite)
    {
        $this->tramites[] = $tramite;

        return $this;
    }

    /**
     * Remove tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     */
    public function removeTramite(\AppBundle\Entity\Tramite $tramite)
    {
        $this->tramites->removeElement($tramite);
    }

    /**
     * Get tramites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTramites()
    {
        return $this->tramites;
    }
}
