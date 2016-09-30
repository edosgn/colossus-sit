<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoIdentificacion
 *
 * @ORM\Table(name="tipo_identificacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoIdentificacionRepository")
 */
class TipoIdentificacion
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ciudadano", mappedBy="tipoIdentificacion")
     */
    protected $ciudadanos;  


    public function __construct() {
        $this->ciudadanos = new \Doctrine\Common\Collections\ArrayCollection();       
    }

    public function __toString()
    {
        return $this->getNombre();
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
     * @return TipoIdentificacion
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
     * Add ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return TipoIdentificacion
     */
    public function addCiudadano(\AppBundle\Entity\Ciudadano $ciudadano)
    {
        $this->ciudadanos[] = $ciudadano;

        return $this;
    }

    /**
     * Remove ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     */
    public function removeCiudadano(\AppBundle\Entity\Ciudadano $ciudadano)
    {
        $this->ciudadanos->removeElement($ciudadano);
    }

    /**
     * Get ciudadanos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCiudadanos()
    {
        return $this->ciudadanos;
    }
}
