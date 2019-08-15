<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpCdp
 *
 * @ORM\Table(name="bp_cdp")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpCdpRepository")
 */
class BpCdp
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
     * @ORM\Column(name="solicitud_numero", type="bigint")
     */
    private $solicitudNumero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="solicitud_fecha", type="date")
     */
    private $solicitudFecha;

    /**
     * @var int
     *
     * @ORM\Column(name="solicitud_consecutivo", type="integer")
     */
    private $solicitudConsecutivo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="bigint", nullable=true)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date", nullable=true)
     */
    private $fechaExpedicion;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_letras", type="text", nullable=true)
     */
    private $valorLetras;

    /**
     * @var int
     *
     * @ORM\Column(name="saldo", type="integer", nullable=true)
     */
    private $saldo;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="text", nullable=true)
     */
    private $concepto;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="BpActividad")
     **/
    protected $actividad;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="cdps") */
    private $expide;


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
     * Set solicitudNumero
     *
     * @param integer $solicitudNumero
     *
     * @return BpCdp
     */
    public function setSolicitudNumero($solicitudNumero)
    {
        $this->solicitudNumero = $solicitudNumero;

        return $this;
    }

    /**
     * Get solicitudNumero
     *
     * @return integer
     */
    public function getSolicitudNumero()
    {
        return $this->solicitudNumero;
    }

    /**
     * Set solicitudFecha
     *
     * @param \DateTime $solicitudFecha
     *
     * @return BpCdp
     */
    public function setSolicitudFecha($solicitudFecha)
    {
        $this->solicitudFecha = $solicitudFecha;

        return $this;
    }

    /**
     * Get solicitudFecha
     *
     * @return \DateTime
     */
    public function getSolicitudFecha()
    {
        return $this->solicitudFecha;
    }

    /**
     * Set solicitudConsecutivo
     *
     * @param integer $solicitudConsecutivo
     *
     * @return BpCdp
     */
    public function setSolicitudConsecutivo($solicitudConsecutivo)
    {
        $this->solicitudConsecutivo = $solicitudConsecutivo;

        return $this;
    }

    /**
     * Get solicitudConsecutivo
     *
     * @return integer
     */
    public function getSolicitudConsecutivo()
    {
        return $this->solicitudConsecutivo;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return BpCdp
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return BpCdp
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return BpCdp
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return \DateTime
     */
    public function getFechaExpedicion()
    {
        return $this->fechaExpedicion;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpCdp
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorLetras
     *
     * @param string $valorLetras
     *
     * @return BpCdp
     */
    public function setValorLetras($valorLetras)
    {
        $this->valorLetras = $valorLetras;

        return $this;
    }

    /**
     * Get valorLetras
     *
     * @return string
     */
    public function getValorLetras()
    {
        return $this->valorLetras;
    }

    /**
     * Set saldo
     *
     * @param integer $saldo
     *
     * @return BpCdp
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return integer
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return BpCdp
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return BpCdp
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return BpCdp
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
     * @return BpCdp
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
     * Set actividad
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad
     *
     * @return BpCdp
     */
    public function setActividad(\JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpActividad
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set expide
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $expide
     *
     * @return BpCdp
     */
    public function setExpide(\JHWEB\PersonalBundle\Entity\PnalFuncionario $expide = null)
    {
        $this->expide = $expide;

        return $this;
    }

    /**
     * Get expide
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getExpide()
    {
        return $this->expide;
    }
}
