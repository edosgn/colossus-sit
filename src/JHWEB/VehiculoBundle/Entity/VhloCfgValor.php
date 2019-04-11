<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgValor
 *
 * @ORM\Table(name="vhlo_cfg_valor")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgValorRepository")
 */
class VhloCfgValor
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
     * @ORM\Column(name="cilindraje", type="string", length=255)
     */
    private $cilindraje;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=255)
     */
    private $anio;

    /**
     * @var string
     *
     * @ORM\Column(name="pesaje", type="string", length=255)
     */
    private $pesaje;

    /**
     * @var string
     *
     * @ORM\Column(name="tonelaje", type="string", length=255)
     */
    private $tonelaje;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255)
     */
    private $valor;

    /** @ORM\ManyToOne(targetEntity="VhloCfgMarca", inversedBy="vehiculos") */
    private $marca;

    /** @ORM\ManyToOne(targetEntity="VhloCfgLinea", inversedBy="vehiculos") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="VhloCfgClase", inversedBy="vehiculos") */
    private $clase;

    


    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cilindraje
     *
     * @param string $cilindraje
     *
     * @return VhloCfgValor
     */
    public function setCilindraje($cilindraje)
    {
        $this->cilindraje = $cilindraje;

        return $this;
    }

    /**
     * Get cilindraje
     *
     * @return string
     */
    public function getCilindraje()
    {
        return $this->cilindraje;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return VhloCfgValor
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set pesaje
     *
     * @param string $pesaje
     *
     * @return VhloCfgValor
     */
    public function setPesaje($pesaje)
    {
        $this->pesaje = $pesaje;

        return $this;
    }

    /**
     * Get pesaje
     *
     * @return string
     */
    public function getPesaje()
    {
        return $this->pesaje;
    }

    /**
     * Set tonelaje
     *
     * @param string $tonelaje
     *
     * @return VhloCfgValor
     */
    public function setTonelaje($tonelaje)
    {
        $this->tonelaje = $tonelaje;

        return $this;
    }

    /**
     * Get tonelaje
     *
     * @return string
     */
    public function getTonelaje()
    {
        return $this->tonelaje;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloCfgValor
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return VhloCfgValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set marca
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgMarca $marca
     *
     * @return VhloCfgValor
     */
    public function setMarca(\JHWEB\VehiculoBundle\Entity\VhloCfgMarca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgMarca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set linea
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea
     *
     * @return VhloCfgValor
     */
    public function setLinea(\JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLinea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return VhloCfgValor
     */
    public function setClase(\JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgClase
     */
    public function getClase()
    {
        return $this->clase;
    }
}
