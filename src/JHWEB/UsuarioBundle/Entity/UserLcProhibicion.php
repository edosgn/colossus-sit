<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLcProhibicion
 *
 * @ORM\Table(name="user_lc_prohibicion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLcProhibicionRepository")
 */
class UserLcProhibicion
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
     * @ORM\Column(name="num_resolucion", type="string", length=255, nullable=true)
     */
    private $numResolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="num_proceso", type="string", length=255, nullable=true)
     */
    private $numProceso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_orden", type="date", nullable=true)
     */
    private $fechaOrden;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_resolucion", type="date", nullable=true)
     */
    private $fechaResolucion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_plazo", type="date", nullable=true)
     */
    private $fechaPlazo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_orden", type="string", length=255)
     */
    private $tipoOrden;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_novedad", type="string", length=255)
     */
    private $tipoNovedad;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="string", length=255)
     */
    private $motivo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="ciudadanos") */
    private $juzgado;


    /**
     * @ORM\ManyToOne(targetEntity="UserCiudadano", inversedBy="limitaciones")
     **/
    protected $usuario;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numResolucion
     *
     * @param string $numResolucion
     *
     * @return UserLcProhibicion
     */
    public function setNumResolucion($numResolucion)
    {
        $this->numResolucion = $numResolucion;

        return $this;
    }

    /**
     * Get numResolucion
     *
     * @return string
     */
    public function getNumResolucion()
    {
        return $this->numResolucion;
    }

    /**
     * Set numProceso
     *
     * @param string $numProceso
     *
     * @return UserLcProhibicion
     */
    public function setNumProceso($numProceso)
    {
        $this->numProceso = $numProceso;

        return $this;
    }

    /**
     * Get numProceso
     *
     * @return string
     */
    public function getNumProceso()
    {
        return $this->numProceso;
    }

    /**
     * Set fechaOrden
     *
     * @param \DateTime $fechaOrden
     *
     * @return UserLcProhibicion
     */
    public function setFechaOrden($fechaOrden)
    {
        $this->fechaOrden = $fechaOrden;

        return $this;
    }

    /**
     * Get fechaOrden
     *
     * @return \DateTime
     */
    public function getFechaOrden()
    {
        return $this->fechaOrden;
    }

    /**
     * Set fechaResolucion
     *
     * @param \DateTime $fechaResolucion
     *
     * @return UserLcProhibicion
     */
    public function setFechaResolucion($fechaResolucion)
    {
        $this->fechaResolucion = $fechaResolucion;

        return $this;
    }

    /**
     * Get fechaResolucion
     *
     * @return \DateTime
     */
    public function getFechaResolucion()
    {
        return $this->fechaResolucion;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return UserLcProhibicion
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return UserLcProhibicion
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set fechaPlazo
     *
     * @param \DateTime $fechaPlazo
     *
     * @return UserLcProhibicion
     */
    public function setFechaPlazo($fechaPlazo)
    {
        $this->fechaPlazo = $fechaPlazo;

        return $this;
    }

    /**
     * Get fechaPlazo
     *
     * @return \DateTime
     */
    public function getFechaPlazo()
    {
        return $this->fechaPlazo;
    }

    /**
     * Set tipoOrden
     *
     * @param string $tipoOrden
     *
     * @return UserLcProhibicion
     */
    public function setTipoOrden($tipoOrden)
    {
        $this->tipoOrden = $tipoOrden;

        return $this;
    }

    /**
     * Get tipoOrden
     *
     * @return string
     */
    public function getTipoOrden()
    {
        return $this->tipoOrden;
    }

    /**
     * Set tipoNovedad
     *
     * @param string $tipoNovedad
     *
     * @return UserLcProhibicion
     */
    public function setTipoNovedad($tipoNovedad)
    {
        $this->tipoNovedad = $tipoNovedad;

        return $this;
    }

    /**
     * Get tipoNovedad
     *
     * @return string
     */
    public function getTipoNovedad()
    {
        return $this->tipoNovedad;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return UserLcProhibicion
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set juzgado
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $juzgado
     *
     * @return UserLcProhibicion
     */
    public function setJuzgado(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $juzgado = null)
    {
        $this->juzgado = $juzgado;

        return $this;
    }

    /**
     * Get juzgado
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getJuzgado()
    {
        return $this->juzgado;
    }

    /**
     * Set usuario
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $usuario
     *
     * @return UserLcProhibicion
     */
    public function setUsuario(\JHWEB\UsuarioBundle\Entity\UserCiudadano $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
