<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MparqGrua
 *
 * @ORM\Table(name="mparq_grua")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MparqGruaRepository")
 */
class MparqGrua
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
     * @ORM\Column(name="placa", type="string", length=10)
     */
    private $placa;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroInterno", type="string", length=10)
     */
    private $numeroInterno;

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
     * Set placa
     *
     * @param string $placa
     *
     * @return MparqGrua
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MparqGrua
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

