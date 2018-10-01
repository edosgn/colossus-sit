<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgTransporteEspecial
 *
 * @ORM\Table(name="cfg_transporte_especial")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\CfgTransporteEspecialRepository")
 */
class CfgTransporteEspecial
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="CfgTransportePasajero", inversedBy="transportesEspeciales") */
    private $transportePasajero;


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
     * @return CfgTransporteEspecial
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgTransporteEspecial
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set transportePasajero
     *
     * @param \JHWEB\VehiculoBundle\Entity\CfgTransportePasajero $transportePasajero
     *
     * @return CfgTransporteEspecial
     */
    public function setTransportePasajero(\JHWEB\VehiculoBundle\Entity\CfgTransportePasajero $transportePasajero = null)
    {
        $this->transportePasajero = $transportePasajero;

        return $this;
    }

    /**
     * Get transportePasajero
     *
     * @return \JHWEB\VehiculoBundle\Entity\CfgTransportePasajero
     */
    public function getTransportePasajero()
    {
        return $this->transportePasajero;
    }
}
