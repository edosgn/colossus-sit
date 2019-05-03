<?php

namespace JHWEB\ParqueaderoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PqoCfgTarifa
 *
 * @ORM\Table(name="pqo_cfg_tarifa")
 * @ORM\Entity(repositoryClass="JHWEB\ParqueaderoBundle\Repository\PqoCfgTarifaRepository")
 */
class PqoCfgTarifa
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
     * @ORM\Column(name="valor_hora", type="integer")
     */
    private $valorHora;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_acto_administrativo", type="string", length=50)
     */
    private $numeroActoAdministrativo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgTipoVehiculo", inversedBy="tarifas") */
    private $tipoVehiculo;

    /** @ORM\ManyToOne(targetEntity="PqoCfgPatio", inversedBy="tarifas") */
    private $patio;


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
     * Set valorHora
     *
     * @param integer $valorHora
     *
     * @return PqoCfgTarifa
     */
    public function setValorHora($valorHora)
    {
        $this->valorHora = $valorHora;

        return $this;
    }

    /**
     * Get valorHora
     *
     * @return int
     */
    public function getValorHora()
    {
        return $this->valorHora;
    }

    /**
     * Set numeroActoAdministrativo
     *
     * @param string $numeroActoAdministrativo
     *
     * @return PqoCfgTarifa
     */
    public function setNumeroActoAdministrativo($numeroActoAdministrativo)
    {
        $this->numeroActoAdministrativo = $numeroActoAdministrativo;

        return $this;
    }

    /**
     * Get numeroActoAdministrativo
     *
     * @return string
     */
    public function getNumeroActoAdministrativo()
    {
        return $this->numeroActoAdministrativo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PqoCfgTarifa
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PqoCfgTarifa
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
     * @return PqoCfgTarifa
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
     * Set patio
     *
     * @param \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio
     *
     * @return PqoCfgTarifa
     */
    public function setPatio(\JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio = null)
    {
        $this->patio = $patio;

        return $this;
    }

    /**
     * Get patio
     *
     * @return \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio
     */
    public function getPatio()
    {
        return $this->patio;
    }
}
