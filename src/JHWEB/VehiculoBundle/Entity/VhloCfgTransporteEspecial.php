<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloCfgTransporteEspecial
 *
 * @ORM\Table(name="vhlo_cfg_transporte_especial")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloCfgTransporteEspecialRepository")
 */
class VhloCfgTransporteEspecial
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

    /** @ORM\ManyToOne(targetEntity="VhloCfgTransportePasajero", inversedBy="transportesEspeciales") */
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
     * @return VhloCfgTransporteEspecial
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
     * @return VhloCfgTransporteEspecial
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
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero $transportePasajero
     *
     * @return VhloCfgTransporteEspecial
     */
    public function setTransportePasajero(\JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero $transportePasajero = null)
    {
        $this->transportePasajero = $transportePasajero;

        return $this;
    }

    /**
     * Get transportePasajero
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgTransportePasajero
     */
    public function getTransportePasajero()
    {
        return $this->transportePasajero;
    }
}
