<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpAsignacion
 *
 * @ORM\Table(name="vhlo_tp_asignacion")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpAsignacionRepository")
 */
class VhloTpAsignacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte", inversedBy="asignaciones") */
    private $empresaTransporte;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloVehiculo", inversedBy="asignaciones") */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloTpCupo", inversedBy="asignaciones") */
    private $cupo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTpAsignacion
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
     * Set empresaTransporte
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte $empresaTransporte
     *
     * @return VhloTpAsignacion
     */
    public function setEmpresaTransporte(\JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte $empresaTransporte = null)
    {
        $this->empresaTransporte = $empresaTransporte;

        return $this;
    }

    /**
     * Get empresaTransporte
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte
     */
    public function getEmpresaTransporte()
    {
        return $this->empresaTransporte;
    }

    /**
     * Set vehiculo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo
     *
     * @return VhloTpAsignacion
     */
    public function setVehiculo(\JHWEB\VehiculoBundle\Entity\VhloVehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloVehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set cupo
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloTpCupo $cupo
     *
     * @return VhloTpAsignacion
     */
    public function setCupo(\JHWEB\VehiculoBundle\Entity\VhloTpCupo $cupo = null)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloTpCupo
     */
    public function getCupo()
    {
        return $this->cupo;
    }
}
