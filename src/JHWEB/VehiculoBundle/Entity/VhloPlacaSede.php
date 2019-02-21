<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloPlacaSede
 *
 * @ORM\Table(name="vhlo_placa_sede")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloPlacaSedeRepository")
 */
class VhloPlacaSede
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
     * @ORM\Column(name="letras_placa", type="string", length=255)
     */
    private $letrasPlaca;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_inicial", type="string", length=10)
     */
    private $numeroInicial;

     /**
     * @var string
     *
     * @ORM\Column(name="numero_final", type="string", length=255)
     */
    private $numeroFinal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgTipoVehiculo", inversedBy="placas")
     **/
    protected $tipoVehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="placas")
     **/
    protected $organismoTransito;


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
     * Set letrasPlaca
     *
     * @param string $letrasPlaca
     *
     * @return VhloPlacaSede
     */
    public function setLetrasPlaca($letrasPlaca)
    {
        $this->letrasPlaca = $letrasPlaca;

        return $this;
    }

    /**
     * Get letrasPlaca
     *
     * @return string
     */
    public function getLetrasPlaca()
    {
        return $this->letrasPlaca;
    }

    /**
     * Set numeroInicial
     *
     * @param string $numeroInicial
     *
     * @return VhloPlacaSede
     */
    public function setNumeroInicial($numeroInicial)
    {
        $this->numeroInicial = $numeroInicial;

        return $this;
    }

    /**
     * Get numeroInicial
     *
     * @return string
     */
    public function getNumeroInicial()
    {
        return $this->numeroInicial;
    }

    /**
     * Set numeroFinal
     *
     * @param string $numeroFinal
     *
     * @return VhloPlacaSede
     */
    public function setNumeroFinal($numeroFinal)
    {
        $this->numeroFinal = $numeroFinal;

        return $this;
    }

    /**
     * Get numeroFinal
     *
     * @return string
     */
    public function getNumeroFinal()
    {
        return $this->numeroFinal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloPlacaSede
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
     * Set tipoVehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo
     *
     * @return VhloPlacaSede
     */
    public function setTipoVehiculo(\JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }

    /**
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return VhloPlacaSede
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }
}
