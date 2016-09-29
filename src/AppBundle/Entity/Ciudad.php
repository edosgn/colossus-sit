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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehiculo", mappedBy="ciudad")
     */
    protected $vehiculos; 

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Empresa", mappedBy="ciudad")
     */
    protected $empresas;

    public function __construct() {
        $this->vehiculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="ciudades") */
    private $departamento; 


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

    /**
     * Set departamento
     *
     * @param \AppBundle\Entity\Departamento $departamento
     *
     * @return Ciudad
     */
    public function setDepartamento(\AppBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Add vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return Ciudad
     */
    public function addVehiculo(\AppBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos[] = $vehiculo;

        return $this;
    }

    /**
     * Remove vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     */
    public function removeVehiculo(\AppBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos->removeElement($vehiculo);
    }

    /**
     * Get vehiculos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehiculos()
    {
        return $this->vehiculos;
    }

    /**
     * Add empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Ciudad
     */
    public function addEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     */
    public function removeEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas->removeElement($empresa);
    }

    /**
     * Get empresas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }
}
