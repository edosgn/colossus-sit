<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpCupo
 *
 * @ORM\Table(name="vhlo_tp_cupo")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpCupoRepository")
 */
class VhloTpCupo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresaTransporte", inversedBy="cupos") */
    private $empresaTransporte;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;

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
     * Set numero
     *
     * @param string $numero
     *
     * @return VhloTpCupo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return VhloTpCupo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return VhloTpCupo
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
     * @return VhloTpCupo
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
}
