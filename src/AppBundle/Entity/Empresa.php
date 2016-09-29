<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @var int
     *
     * @ORM\Column(name="nitEmpresa", type="integer")
     */
    private $nitEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEmpresa", type="string", length=255)
     */
    private $nombreEmpresa;

    /**
     * @var int
     *
     * @ORM\Column(name="telefonoEmpresa", type="integer")
     */
    private $telefonoEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionEmpresa", type="string", length=255)
     */
    private $direccionEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="correoEmpresa", type="string", length=255)
     */
    private $correoEmpresa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudad", inversedBy="empresas") */
    private $ciudad;


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
     * Set nitEmpresa
     *
     * @param integer $nitEmpresa
     *
     * @return Empresa
     */
    public function setNitEmpresa($nitEmpresa)
    {
        $this->nitEmpresa = $nitEmpresa;

        return $this;
    }

    /**
     * Get nitEmpresa
     *
     * @return int
     */
    public function getNitEmpresa()
    {
        return $this->nitEmpresa;
    }

    /**
     * Set nombreEmpresa
     *
     * @param string $nombreEmpresa
     *
     * @return Empresa
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    /**
     * Get nombreEmpresa
     *
     * @return string
     */
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * Set telefonoEmpresa
     *
     * @param integer $telefonoEmpresa
     *
     * @return Empresa
     */
    public function setTelefonoEmpresa($telefonoEmpresa)
    {
        $this->telefonoEmpresa = $telefonoEmpresa;

        return $this;
    }

    /**
     * Get telefonoEmpresa
     *
     * @return int
     */
    public function getTelefonoEmpresa()
    {
        return $this->telefonoEmpresa;
    }

    /**
     * Set direccionEmpresa
     *
     * @param string $direccionEmpresa
     *
     * @return Empresa
     */
    public function setDireccionEmpresa($direccionEmpresa)
    {
        $this->direccionEmpresa = $direccionEmpresa;

        return $this;
    }

    /**
     * Get direccionEmpresa
     *
     * @return string
     */
    public function getDireccionEmpresa()
    {
        return $this->direccionEmpresa;
    }

    /**
     * Set correoEmpresa
     *
     * @param string $correoEmpresa
     *
     * @return Empresa
     */
    public function setCorreoEmpresa($correoEmpresa)
    {
        $this->correoEmpresa = $correoEmpresa;

        return $this;
    }

    /**
     * Get correoEmpresa
     *
     * @return string
     */
    public function getCorreoEmpresa()
    {
        return $this->correoEmpresa;
    }

    /**
     * Set ciudad
     *
     * @param \AppBundle\Entity\Ciudad $ciudad
     *
     * @return Empresa
     */
    public function setCiudad(\AppBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \AppBundle\Entity\Ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }
}
