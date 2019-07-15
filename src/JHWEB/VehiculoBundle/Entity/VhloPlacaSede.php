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
     * @ORM\Column(name="rango_inicial", type="string", length=10)
     */
    private $rangoInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="rango_final", type="string", length=10)
     */
    private $rangoFinal;

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
     * Set rangoInicial
     *
     * @param string $rangoInicial
     *
     * @return VhloPlacaSede
     */
    public function setRangoInicial($rangoInicial)
    {
        $this->rangoInicial = $rangoInicial;

        return $this;
    }

    /**
     * Get rangoInicial
     *
     * @return string
     */
    public function getRangoInicial()
    {
        return $this->rangoInicial;
    }

    /**
     * Set rangoFinal
     *
     * @param string $rangoFinal
     *
     * @return VhloPlacaSede
     */
    public function setRangoFinal($rangoFinal)
    {
        $this->rangoFinal = $rangoFinal;

        return $this;
    }

    /**
     * Get rangoFinal
     *
     * @return string
     */
    public function getRangoFinal()
    {
        return $this->rangoFinal;
    }

    /**
     * Set letraFinal
     *
     * @param string $letraFinal
     *
     * @return VhloPlacaSede
     */
    public function setLetraFinal($letraFinal)
    {
        $this->letraFinal = $letraFinal;

        return $this;
    }

    /**
     * Get letraFinal
     *
     * @return string
     */
    public function getLetraFinal()
    {
        return $this->letraFinal;
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
