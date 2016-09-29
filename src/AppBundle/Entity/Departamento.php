<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamento
 *
 * @ORM\Table(name="departamento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartamentoRepository")
 */
class Departamento
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
     * @ORM\Column(name="nombreDepartamento", type="string", length=255)
     */
    private $nombreDepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoDepartamento", type="string", length=255)
     */
    private $codigoDepartamento;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ciudad", mappedBy="departamento")
     */
    protected $ciudades; 

    public function __construct() {
        $this->ciudades = new \Doctrine\Common\Collections\ArrayCollection();
        
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
     * Set nombreDepartamento
     *
     * @param string $nombreDepartamento
     *
     * @return Departamento
     */
    public function setNombreDepartamento($nombreDepartamento)
    {
        $this->nombreDepartamento = $nombreDepartamento;

        return $this;
    }

    /**
     * Get nombreDepartamento
     *
     * @return string
     */
    public function getNombreDepartamento()
    {
        return $this->nombreDepartamento;
    }

    /**
     * Set codigoDepartamento
     *
     * @param string $codigoDepartamento
     *
     * @return Departamento
     */
    public function setCodigoDepartamento($codigoDepartamento)
    {
        $this->codigoDepartamento = $codigoDepartamento;

        return $this;
    }

    /**
     * Get codigoDepartamento
     *
     * @return string
     */
    public function getCodigoDepartamento()
    {
        return $this->codigoDepartamento;
    }

    /**
     * Add ciudade
     *
     * @param \AppBundle\Entity\Ciudad $ciudade
     *
     * @return Departamento
     */
    public function addCiudade(\AppBundle\Entity\Ciudad $ciudade)
    {
        $this->ciudades[] = $ciudade;

        return $this;
    }

    /**
     * Remove ciudade
     *
     * @param \AppBundle\Entity\Ciudad $ciudade
     */
    public function removeCiudade(\AppBundle\Entity\Ciudad $ciudade)
    {
        $this->ciudades->removeElement($ciudade);
    }

    /**
     * Get ciudades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCiudades()
    {
        return $this->ciudades;
    }
}
