<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgAsignacionPlacaSede
 *
 * @ORM\Table(name="cfg_asignacion_placa_sede")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgAsignacionPlacaSedeRepository")
 */
class CfgAsignacionPlacaSede
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
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="sedes") */
    private $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoVehiculo", inversedBy="tipos") */
    private $tipoVehiculo;    

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="modulos") */
    private $modulo;

    /**
     * @var string
     *
     * @ORM\Column(name="letrasPlaca", type="string", length=255)
     */
    private $letrasPlaca;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_inicial", type="string", length=10)
     */
    private $numeroInicial;

     /**
     * @var string
     *
     * @ORM\Column(name="numero_final", type="string", length=255)
     */
    private $numeroFinal;

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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set letrasPlaca
     *
     * @param string $letrasPlaca
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setLetrasPlaca($letrasPlaca)
    {
        $this->letrasPlaca = $letrasPlaca;

        return $this;
    }

    /**
     * Get letrasPlaca
     *
     * @return string
     */
    public function getLetrasPlaca()
    {
        return $this->letrasPlaca;
    }

    /**
     * Set numeroInicial
     *
     * @param string $numeroInicial
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setNumeroInicial($numeroInicial)
    {
        $this->numeroInicial = $numeroInicial;

        return $this;
    }

    /**
     * Get numeroInicial
     *
     * @return string
     */
    public function getNumeroInicial()
    {
        return $this->numeroInicial;
    }

    /**
     * Set numeroFinal
     *
     * @param string $numeroFinal
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setNumeroFinal($numeroFinal)
    {
        $this->numeroFinal = $numeroFinal;

        return $this;
    }

    /**
     * Get numeroFinal
     *
     * @return string
     */
    public function getNumeroFinal()
    {
        return $this->numeroFinal;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set tipoVehiculo
     *
     * @param \AppBundle\Entity\CfgTipoVehiculo $tipoVehiculo
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setTipoVehiculo(\AppBundle\Entity\CfgTipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \AppBundle\Entity\CfgTipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }

    /**
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return CfgAsignacionPlacaSede
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
