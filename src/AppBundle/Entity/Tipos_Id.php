<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipos_Id
 *
 * @ORM\Table(name="tipos__id")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tipos_IdRepository")
 */
class Tipos_Id
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Propietario", mappedBy="Tipo")
     */
    protected $Propietarios;  


    public function __construct() {
        $this->Propietarios = new \Doctrine\Common\Collections\ArrayCollection();
       
        
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
     * @return Tipos_Id
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
     * @return Tipos_Id
     */
    public function addPropietario(\AppBundle\Entity\Propietario $propietario)
    {
        $this->Propietarios[] = $propietario;

        return $this;
    }

    /**
     * Remove propietario
     *
     * @param \AppBundle\Entity\Propietario $propietario
     */
    public function removePropietario(\AppBundle\Entity\Propietario $propietario)
    {
        $this->Propietarios->removeElement($propietario);
    }

    /**
     * Get propietarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropietarios()
    {
        return $this->Propietarios;
    }
}
