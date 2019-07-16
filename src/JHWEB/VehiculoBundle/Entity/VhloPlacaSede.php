<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloPlacaSede
 *
 * @ORM\Table(name="vhlo_placa_sede")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloPlacaSedeRepository")
 * @ORM\HasLifecycleCallbacks()
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
    * created Time/Date 
    * 
    * @var \DateTime 
    * 
    * @ORM\Column(name="created_at", type="datetime") 
    */  
    protected $createdAt;  
  
    /** 
     * updated Time/Date 
     * 
     * @var \DateTime 
     * 
     * @ORM\Column(name="updated_at", type="datetime") 
     */  
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="VhloCfgTipoVehiculo", inversedBy="placas")
     **/
    protected $tipoVehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="placas")
     **/
    protected $organismoTransito;

    /** @ORM\PrePersist */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /** @ORM\PreUpdate */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
