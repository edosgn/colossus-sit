<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MparqCostoTrayecto
 *
 * @ORM\Table(name="mparq_costo_trayecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MparqCostoTrayectoRepository")
 */
class MparqCostoTrayecto
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
     * @ORM\Column(name="origen", type="string", length=255)
     */
    private $origen;

    /**
     * @var string
     *
     * @ORM\Column(name="destino", type="string", length=255)
     */
    private $destino;

    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float")
     */
    private $costo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;


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
     * Set origen
     *
     * @param string $origen
     *
     * @return MparqCostoTrayecto
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set destino
     *
     * @param string $destino
     *
     * @return MparqCostoTrayecto
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set costo
     *
     * @param float $costo
     *
     * @return MparqCostoTrayecto
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MparqCostoTrayecto
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
}

