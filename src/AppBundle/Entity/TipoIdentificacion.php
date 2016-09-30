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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Propietario", mappedBy="tipoIdentificacion")
     */
    protected $propietarios;  


    public function __construct() {
        $this->propietarios = new \Doctrine\Common\Collections\ArrayCollection();       
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoIdentificacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add propietario
     *
     * @param \AppBundle\Entity\Propietario $propietario
     *
     * @return TipoIdentificacion
     */
    public function addPropietario(\AppBundle\Entity\Propietario $propietario)
    {
        $this->propietarios[] = $propietario;

        return $this;
    }

    /**
     * Remove propietario
     *
     * @param \AppBundle\Entity\Propietario $propietario
     */
    public function removePropietario(\AppBundle\Entity\Propietario $propietario)
    {
        $this->propietarios->removeElement($propietario);
    }

    /**
     * Get propietarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropietarios()
    {
        return $this->propietarios;
    }
}
