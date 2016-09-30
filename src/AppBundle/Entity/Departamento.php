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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoDian", type="string", length=255)
     */
    private $codigoDian;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Municipio", mappedBy="departamento")
     */
    protected $municipios; 

    public function __construct() {
        $this->municipios = new \Doctrine\Common\Collections\ArrayCollection();
        
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
     * @return Departamento
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
     * Set codigoDian
     *
     * @param string $codigoDian
     *
     * @return Departamento
     */
    public function setCodigoDian($codigoDian)
    {
        $this->codigoDian = $codigoDian;

        return $this;
    }

    /**
     * Get codigoDian
     *
     * @return string
     */
    public function getCodigoDian()
    {
        return $this->codigoDian;
    }

    /**
     * Add municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Departamento
     */
    public function addMunicipio(\AppBundle\Entity\Municipio $municipio)
    {
        $this->municipios[] = $municipio;

        return $this;
    }

    /**
     * Remove municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     */
    public function removeMunicipio(\AppBundle\Entity\Municipio $municipio)
    {
        $this->municipios->removeElement($municipio);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
