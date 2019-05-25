<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatVehiculo
 *
 * @ORM\Table(name="sv_ipat_vehiculo")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatVehiculoRepository")
 */
class SvIpatVehiculo
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
     * @ORM\Column(name="placa", type="string", nullable = true)
     */
    private $placa;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_placa", type="boolean", nullable = true)
     */
    private $portaPlaca;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_remolque", type="string", nullable = true)
     */
    private $placaRemolque;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad", type="string", nullable = true)
     */
    private $nacionalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", nullable = true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="linea", type="string", nullable = true)
     */
    private $linea;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", nullable = true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", nullable = true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="carroceria", type="string", nullable = true)
     */
    private $carroceria;
     /**
     * @var string
     *
     * @ORM\Column(name="clase", type="string", nullable = true)
     */
    private $clase;

     /**
     * @var string
     *
     * @ORM\Column(name="servicio", type="string", nullable = true)
     */
    private $servicio;

     /**
     * @var string
     *
     * @ORM\Column(name="modalidad_transporte", type="string", nullable = true)
     */
    private $modalidadTransporte;

     /**
     * @var string
     *
     * @ORM\Column(name="radio_accion", type="string", nullable = true)
     */
    private $radioAccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ton", type="string", nullable = true)
     */
    private $ton;

    /**
     * @var string
     *
     * @ORM\Column(name="pasajeros", type="string", nullable = true)
     */
    private $pasajeros;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", nullable = true)
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="nitEmpresa", type="string", nullable = true)
     */
    private $nitEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="matriculado_en", type="string", nullable = true)
     */
    private $matriculadoEn;

    /**
     * @var bool
     *
     * @ORM\Column(name="inmovilizado", type="boolean", nullable = true)
     */
    private $inmovilizado;

    /**
     * @var string
     *
     * @ORM\Column(name="inmovilizado_en", type="string", nullable = true)
     */
    private $inmovilizadoEn;

    /**
     * @var string
     *
     * @ORM\Column(name="a_disposicion_de", type="string", nullable = true)
     */
    private $aDisposicionDe;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_tarjetaregistro", type="boolean", nullable = true)
     */
    private $portaTarjetaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="tarjeta_registro", type="string", nullable = true)
     */
    private $tarjetaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="revision_tecnomecanica", type="string", nullable = true)
     */
    private $revisionTecnoMecanica;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_tecnomecanica", type="string", nullable = true)
     */
    private $numeroTecnoMecanica;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad_acompaniantes", type="string", nullable = true)
     */
    private $cantidadAcompaniantes;

    /**
     * @var string
     *
     * @ORM\Column(name="portaSoat", type="string", nullable = true)
     */
    private $portaSoat;

    /**
     * @var int
     *
     * @ORM\Column(name="soat", type="integer", nullable = true)
     */
    private $soat;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroPoliza", type="integer", nullable = true)
     */
    private $numeroPoliza;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_soat", type="string", nullable = true)
     */
    private $aseguradoraSoat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_soat", type="date", nullable = true)
     */
    private $fechaVencimientoSoat;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_seguro_responsabilidad_civil", type="boolean", nullable = true)
     */
    private $portaSeguroResponsabilidadCivil;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_seguro_responsabilidad_civil", type="integer", nullable = true)
     */
    private $numeroSeguroResponsabilidadCivil;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_seguro_responsabilidad_civil", type="string", nullable = true)
     */
    private $aseguradoraSeguroResponsabilidadCivil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_seguro_responsabilidad_civil", type="date", nullable = true)
     */
    private $fechaVencimientoSeguroResponsabilidadCivil;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_seguro_extracontractual", type="boolean", nullable = true)
     */
    private $portaSeguroExtracontractual;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_seguro_extracontractual", type="integer", nullable = true)
     */
    private $numeroSeguroExtracontractual;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_seguro_extracontractual", type="string", nullable = true)
     */
    private $aseguradoraSeguroExtracontractual;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_seguro_extracontractual", type="date", nullable = true)
     */
    private $fechaVencimientoSeguroExtracontractual;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_danios", type="string", nullable = true)
     */
    private $descripcionDanios;

    /**
     * @var array
     *
     * @ORM\Column(name="falla", type="array", nullable=true)
     */
    private $falla;
    
    /**
     * @var array
     *
     * @ORM\Column(name="lugar_impacto", type="array", nullable=true)
     */
    private $lugarImpacto;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo", inversedBy="victimas")
     */
    private $consecutivo;

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
     * @return SvIpatVehiculo
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
     * Set portaPlaca
     *
     * @param boolean $portaPlaca
     *
     * @return SvIpatVehiculo
     */
    public function setPortaPlaca($portaPlaca)
    {
        $this->portaPlaca = $portaPlaca;

        return $this;
    }

    /**
     * Get portaPlaca
     *
     * @return boolean
     */
    public function getPortaPlaca()
    {
        return $this->portaPlaca;
    }

    /**
     * Set placaRemolque
     *
     * @param string $placaRemolque
     *
     * @return SvIpatVehiculo
     */
    public function setPlacaRemolque($placaRemolque)
    {
        $this->placaRemolque = $placaRemolque;

        return $this;
    }

    /**
     * Get placaRemolque
     *
     * @return string
     */
    public function getPlacaRemolque()
    {
        return $this->placaRemolque;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return SvIpatVehiculo
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return SvIpatVehiculo
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set linea
     *
     * @param string $linea
     *
     * @return SvIpatVehiculo
     */
    public function setLinea($linea)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return string
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return SvIpatVehiculo
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return SvIpatVehiculo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set carroceria
     *
     * @param string $carroceria
     *
     * @return SvIpatVehiculo
     */
    public function setCarroceria($carroceria)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return string
     */
    public function getCarroceria()
    {
        return $this->carroceria;
    }

    /**
     * Set clase
     *
     * @param string $clase
     *
     * @return SvIpatVehiculo
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set servicio
     *
     * @param string $servicio
     *
     * @return SvIpatVehiculo
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return string
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set modalidadTransporte
     *
     * @param string $modalidadTransporte
     *
     * @return SvIpatVehiculo
     */
    public function setModalidadTransporte($modalidadTransporte)
    {
        $this->modalidadTransporte = $modalidadTransporte;

        return $this;
    }

    /**
     * Get modalidadTransporte
     *
     * @return string
     */
    public function getModalidadTransporte()
    {
        return $this->modalidadTransporte;
    }

    /**
     * Set radioAccion
     *
     * @param string $radioAccion
     *
     * @return SvIpatVehiculo
     */
    public function setRadioAccion($radioAccion)
    {
        $this->radioAccion = $radioAccion;

        return $this;
    }

    /**
     * Get radioAccion
     *
     * @return string
     */
    public function getRadioAccion()
    {
        return $this->radioAccion;
    }

    /**
     * Set ton
     *
     * @param string $ton
     *
     * @return SvIpatVehiculo
     */
    public function setTon($ton)
    {
        $this->ton = $ton;

        return $this;
    }

    /**
     * Get ton
     *
     * @return string
     */
    public function getTon()
    {
        return $this->ton;
    }

    /**
     * Set pasajeros
     *
     * @param string $pasajeros
     *
     * @return SvIpatVehiculo
     */
    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;

        return $this;
    }

    /**
     * Get pasajeros
     *
     * @return string
     */
    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return SvIpatVehiculo
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set nitEmpresa
     *
     * @param string $nitEmpresa
     *
     * @return SvIpatVehiculo
     */
    public function setNitEmpresa($nitEmpresa)
    {
        $this->nitEmpresa = $nitEmpresa;

        return $this;
    }

    /**
     * Get nitEmpresa
     *
     * @return string
     */
    public function getNitEmpresa()
    {
        return $this->nitEmpresa;
    }

    /**
     * Set matriculadoEn
     *
     * @param string $matriculadoEn
     *
     * @return SvIpatVehiculo
     */
    public function setMatriculadoEn($matriculadoEn)
    {
        $this->matriculadoEn = $matriculadoEn;

        return $this;
    }

    /**
     * Get matriculadoEn
     *
     * @return string
     */
    public function getMatriculadoEn()
    {
        return $this->matriculadoEn;
    }

    /**
     * Set inmovilizado
     *
     * @param boolean $inmovilizado
     *
     * @return SvIpatVehiculo
     */
    public function setInmovilizado($inmovilizado)
    {
        $this->inmovilizado = $inmovilizado;

        return $this;
    }

    /**
     * Get inmovilizado
     *
     * @return boolean
     */
    public function getInmovilizado()
    {
        return $this->inmovilizado;
    }

    /**
     * Set inmovilizadoEn
     *
     * @param string $inmovilizadoEn
     *
     * @return SvIpatVehiculo
     */
    public function setInmovilizadoEn($inmovilizadoEn)
    {
        $this->inmovilizadoEn = $inmovilizadoEn;

        return $this;
    }

    /**
     * Get inmovilizadoEn
     *
     * @return string
     */
    public function getInmovilizadoEn()
    {
        return $this->inmovilizadoEn;
    }

    /**
     * Set aDisposicionDe
     *
     * @param string $aDisposicionDe
     *
     * @return SvIpatVehiculo
     */
    public function setADisposicionDe($aDisposicionDe)
    {
        $this->aDisposicionDe = $aDisposicionDe;

        return $this;
    }

    /**
     * Get aDisposicionDe
     *
     * @return string
     */
    public function getADisposicionDe()
    {
        return $this->aDisposicionDe;
    }

    /**
     * Set portaTarjetaRegistro
     *
     * @param boolean $portaTarjetaRegistro
     *
     * @return SvIpatVehiculo
     */
    public function setPortaTarjetaRegistro($portaTarjetaRegistro)
    {
        $this->portaTarjetaRegistro = $portaTarjetaRegistro;

        return $this;
    }

    /**
     * Get portaTarjetaRegistro
     *
     * @return boolean
     */
    public function getPortaTarjetaRegistro()
    {
        return $this->portaTarjetaRegistro;
    }

    /**
     * Set tarjetaRegistro
     *
     * @param string $tarjetaRegistro
     *
     * @return SvIpatVehiculo
     */
    public function setTarjetaRegistro($tarjetaRegistro)
    {
        $this->tarjetaRegistro = $tarjetaRegistro;

        return $this;
    }

    /**
     * Get tarjetaRegistro
     *
     * @return string
     */
    public function getTarjetaRegistro()
    {
        return $this->tarjetaRegistro;
    }

    /**
     * Set revisionTecnoMecanica
     *
     * @param string $revisionTecnoMecanica
     *
     * @return SvIpatVehiculo
     */
    public function setRevisionTecnoMecanica($revisionTecnoMecanica)
    {
        $this->revisionTecnoMecanica = $revisionTecnoMecanica;

        return $this;
    }

    /**
     * Get revisionTecnoMecanica
     *
     * @return string
     */
    public function getRevisionTecnoMecanica()
    {
        return $this->revisionTecnoMecanica;
    }

    /**
     * Set numeroTecnoMecanica
     *
     * @param string $numeroTecnoMecanica
     *
     * @return SvIpatVehiculo
     */
    public function setNumeroTecnoMecanica($numeroTecnoMecanica)
    {
        $this->numeroTecnoMecanica = $numeroTecnoMecanica;

        return $this;
    }

    /**
     * Get numeroTecnoMecanica
     *
     * @return string
     */
    public function getNumeroTecnoMecanica()
    {
        return $this->numeroTecnoMecanica;
    }

    /**
     * Set cantidadAcompaniantes
     *
     * @param string $cantidadAcompaniantes
     *
     * @return SvIpatVehiculo
     */
    public function setCantidadAcompaniantes($cantidadAcompaniantes)
    {
        $this->cantidadAcompaniantes = $cantidadAcompaniantes;

        return $this;
    }

    /**
     * Get cantidadAcompaniantes
     *
     * @return string
     */
    public function getCantidadAcompaniantes()
    {
        return $this->cantidadAcompaniantes;
    }

    /**
     * Set portaSoat
     *
     * @param string $portaSoat
     *
     * @return SvIpatVehiculo
     */
    public function setPortaSoat($portaSoat)
    {
        $this->portaSoat = $portaSoat;

        return $this;
    }

    /**
     * Get portaSoat
     *
     * @return string
     */
    public function getPortaSoat()
    {
        return $this->portaSoat;
    }

    /**
     * Set soat
     *
     * @param integer $soat
     *
     * @return SvIpatVehiculo
     */
    public function setSoat($soat)
    {
        $this->soat = $soat;

        return $this;
    }

    /**
     * Get soat
     *
     * @return integer
     */
    public function getSoat()
    {
        return $this->soat;
    }

    /**
     * Set numeroPoliza
     *
     * @param integer $numeroPoliza
     *
     * @return SvIpatVehiculo
     */
    public function setNumeroPoliza($numeroPoliza)
    {
        $this->numeroPoliza = $numeroPoliza;

        return $this;
    }

    /**
     * Get numeroPoliza
     *
     * @return integer
     */
    public function getNumeroPoliza()
    {
        return $this->numeroPoliza;
    }

    /**
     * Set aseguradoraSoat
     *
     * @param string $aseguradoraSoat
     *
     * @return SvIpatVehiculo
     */
    public function setAseguradoraSoat($aseguradoraSoat)
    {
        $this->aseguradoraSoat = $aseguradoraSoat;

        return $this;
    }

    /**
     * Get aseguradoraSoat
     *
     * @return string
     */
    public function getAseguradoraSoat()
    {
        return $this->aseguradoraSoat;
    }

    /**
     * Set fechaVencimientoSoat
     *
     * @param \DateTime $fechaVencimientoSoat
     *
     * @return SvIpatVehiculo
     */
    public function setFechaVencimientoSoat($fechaVencimientoSoat)
    {
        $this->fechaVencimientoSoat = $fechaVencimientoSoat;

        return $this;
    }

    /**
     * Get fechaVencimientoSoat
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSoat()
    {
        return $this->fechaVencimientoSoat;
    }

    /**
     * Set portaSeguroResponsabilidadCivil
     *
     * @param boolean $portaSeguroResponsabilidadCivil
     *
     * @return SvIpatVehiculo
     */
    public function setPortaSeguroResponsabilidadCivil($portaSeguroResponsabilidadCivil)
    {
        $this->portaSeguroResponsabilidadCivil = $portaSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get portaSeguroResponsabilidadCivil
     *
     * @return boolean
     */
    public function getPortaSeguroResponsabilidadCivil()
    {
        return $this->portaSeguroResponsabilidadCivil;
    }

    /**
     * Set numeroSeguroResponsabilidadCivil
     *
     * @param integer $numeroSeguroResponsabilidadCivil
     *
     * @return SvIpatVehiculo
     */
    public function setNumeroSeguroResponsabilidadCivil($numeroSeguroResponsabilidadCivil)
    {
        $this->numeroSeguroResponsabilidadCivil = $numeroSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get numeroSeguroResponsabilidadCivil
     *
     * @return integer
     */
    public function getNumeroSeguroResponsabilidadCivil()
    {
        return $this->numeroSeguroResponsabilidadCivil;
    }

    /**
     * Set aseguradoraSeguroResponsabilidadCivil
     *
     * @param string $aseguradoraSeguroResponsabilidadCivil
     *
     * @return SvIpatVehiculo
     */
    public function setAseguradoraSeguroResponsabilidadCivil($aseguradoraSeguroResponsabilidadCivil)
    {
        $this->aseguradoraSeguroResponsabilidadCivil = $aseguradoraSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get aseguradoraSeguroResponsabilidadCivil
     *
     * @return string
     */
    public function getAseguradoraSeguroResponsabilidadCivil()
    {
        return $this->aseguradoraSeguroResponsabilidadCivil;
    }

    /**
     * Set fechaVencimientoSeguroResponsabilidadCivil
     *
     * @param \DateTime $fechaVencimientoSeguroResponsabilidadCivil
     *
     * @return SvIpatVehiculo
     */
    public function setFechaVencimientoSeguroResponsabilidadCivil($fechaVencimientoSeguroResponsabilidadCivil)
    {
        $this->fechaVencimientoSeguroResponsabilidadCivil = $fechaVencimientoSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get fechaVencimientoSeguroResponsabilidadCivil
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSeguroResponsabilidadCivil()
    {
        return $this->fechaVencimientoSeguroResponsabilidadCivil;
    }

    /**
     * Set portaSeguroExtracontractual
     *
     * @param boolean $portaSeguroExtracontractual
     *
     * @return SvIpatVehiculo
     */
    public function setPortaSeguroExtracontractual($portaSeguroExtracontractual)
    {
        $this->portaSeguroExtracontractual = $portaSeguroExtracontractual;

        return $this;
    }

    /**
     * Get portaSeguroExtracontractual
     *
     * @return boolean
     */
    public function getPortaSeguroExtracontractual()
    {
        return $this->portaSeguroExtracontractual;
    }

    /**
     * Set numeroSeguroExtracontractual
     *
     * @param integer $numeroSeguroExtracontractual
     *
     * @return SvIpatVehiculo
     */
    public function setNumeroSeguroExtracontractual($numeroSeguroExtracontractual)
    {
        $this->numeroSeguroExtracontractual = $numeroSeguroExtracontractual;

        return $this;
    }

    /**
     * Get numeroSeguroExtracontractual
     *
     * @return integer
     */
    public function getNumeroSeguroExtracontractual()
    {
        return $this->numeroSeguroExtracontractual;
    }

    /**
     * Set aseguradoraSeguroExtracontractual
     *
     * @param string $aseguradoraSeguroExtracontractual
     *
     * @return SvIpatVehiculo
     */
    public function setAseguradoraSeguroExtracontractual($aseguradoraSeguroExtracontractual)
    {
        $this->aseguradoraSeguroExtracontractual = $aseguradoraSeguroExtracontractual;

        return $this;
    }

    /**
     * Get aseguradoraSeguroExtracontractual
     *
     * @return string
     */
    public function getAseguradoraSeguroExtracontractual()
    {
        return $this->aseguradoraSeguroExtracontractual;
    }

    /**
     * Set fechaVencimientoSeguroExtracontractual
     *
     * @param \DateTime $fechaVencimientoSeguroExtracontractual
     *
     * @return SvIpatVehiculo
     */
    public function setFechaVencimientoSeguroExtracontractual($fechaVencimientoSeguroExtracontractual)
    {
        $this->fechaVencimientoSeguroExtracontractual = $fechaVencimientoSeguroExtracontractual;

        return $this;
    }

    /**
     * Get fechaVencimientoSeguroExtracontractual
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSeguroExtracontractual()
    {
        return $this->fechaVencimientoSeguroExtracontractual;
    }

    /**
     * Set descripcionDanios
     *
     * @param string $descripcionDanios
     *
     * @return SvIpatVehiculo
     */
    public function setDescripcionDanios($descripcionDanios)
    {
        $this->descripcionDanios = $descripcionDanios;

        return $this;
    }

    /**
     * Get descripcionDanios
     *
     * @return string
     */
    public function getDescripcionDanios()
    {
        return $this->descripcionDanios;
    }

    /**
     * Set falla
     *
     * @param array $falla
     *
     * @return SvIpatVehiculo
     */
    public function setFalla($falla)
    {
        $this->falla = $falla;

        return $this;
    }

    /**
     * Get falla
     *
     * @return array
     */
    public function getFalla()
    {
        return $this->falla;
    }

    /**
     * Set lugarImpacto
     *
     * @param array $lugarImpacto
     *
     * @return SvIpatVehiculo
     */
    public function setLugarImpacto($lugarImpacto)
    {
        $this->lugarImpacto = $lugarImpacto;

        return $this;
    }

    /**
     * Get lugarImpacto
     *
     * @return array
     */
    public function getLugarImpacto()
    {
        return $this->lugarImpacto;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatVehiculo
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
     * Set consecutivo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo
     *
     * @return SvIpatVehiculo
     */
    public function setConsecutivo(\JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }
}
