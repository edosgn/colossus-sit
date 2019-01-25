<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacturaTramite
 *
 * @ORM\Table(name="fro_factura_tramite")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacturaTramiteRepository")
 */
class FroFacturaTramite
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
     * @var bool
     *
     * @ORM\Column(name="realizado", type="boolean")
     */
    private $realizado;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

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
     * Set realizado
     *
     * @param boolean $realizado
     *
     * @return FroFacturaTramite
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;

        return $this;
    }

    /**
     * Get realizado
     *
     * @return bool
     */
    public function getRealizado()
    {
        return $this->realizado;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return FroFacturaTramite
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFacturaTramite
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

