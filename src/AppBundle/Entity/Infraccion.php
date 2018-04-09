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
     * @ORM\Column(name="codigo", type="string", length=45)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inmovilizacion", type="boolean")
     */
    private $inmovilizacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suspensionLicencia", type="boolean")
     */
    private $suspensionLicencia;


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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Infraccion
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Infraccion
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
     * Set valor
     *
     * @param float $valor
     *
     * @return Infraccion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Infraccion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set inmovilizacion
     *
     * @param boolean $inmovilizacion
     *
     * @return Infraccion
     */
    public function setInmovilizacion($inmovilizacion)
    {
        $this->inmovilizacion = $inmovilizacion;

        return $this;
    }

    /**
     * Get inmovilizacion
     *
     * @return boolean
     */
    public function getInmovilizacion()
    {
        return $this->inmovilizacion;
    }

    /**
     * Set suspensionLicencia
     *
     * @param boolean $suspensionLicencia
     *
     * @return Infraccion
     */
    public function setSuspensionLicencia($suspensionLicencia)
    {
        $this->suspensionLicencia = $suspensionLicencia;

        return $this;
    }

    /**
     * Get suspensionLicencia
     *
     * @return boolean
     */
    public function getSuspensionLicencia()
    {
        return $this->suspensionLicencia;
    }
}
