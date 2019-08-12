<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpRegistroCompromiso
 *
 * @ORM\Table(name="bp_registro_compromiso")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpRegistroCompromisoRepository")
 */
class BpRegistroCompromiso
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
     * @var string
     *
     * @ORM\Column(name="cuenta_numero", type="string", length=255)
     */
    private $cuentaNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta_tipo", type="string", length=255)
     */
    private $cuentaTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="banco_nombre", type="string", length=255)
     */
    private $bancoNombre;

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
     * @ORM\Column(name="contrato_numero", type="bigint", nullable=true)
     */
    private $contratoNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="contrato_tipo", type="string", length=255, nullable=true)
     */
    private $contratoTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="saldo", type="integer", nullable=true)
     */
    private $saldo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="BpCdp")
     **/
    protected $cdp;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="registros") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="registros") */
    private $empresa;


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
     * @return BpRegistroCompromiso
     */
    public function setSolicitudNumero($solicitudNumero)
    {
        $this->solicitudNumero = $solicitudNumero;

        return $this;
    }

    /**
     * Get solicitudNumero
     *
     * @return int
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
     * @return BpRegistroCompromiso
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
     * @return BpRegistroCompromiso
     */
    public function setSolicitudConsecutivo($solicitudConsecutivo)
    {
        $this->solicitudConsecutivo = $solicitudConsecutivo;

        return $this;
    }

    /**
     * Get solicitudConsecutivo
     *
     * @return int
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
     * @return BpRegistroCompromiso
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set cuentaNumero
     *
     * @param string $cuentaNumero
     *
     * @return BpRegistroCompromiso
     */
    public function setCuentaNumero($cuentaNumero)
    {
        $this->cuentaNumero = $cuentaNumero;

        return $this;
    }

    /**
     * Get cuentaNumero
     *
     * @return string
     */
    public function getCuentaNumero()
    {
        return $this->cuentaNumero;
    }

    /**
     * Set cuentaTipo
     *
     * @param string $cuentaTipo
     *
     * @return BpRegistroCompromiso
     */
    public function setCuentaTipo($cuentaTipo)
    {
        $this->cuentaTipo = $cuentaTipo;

        return $this;
    }

    /**
     * Get cuentaTipo
     *
     * @return string
     */
    public function getCuentaTipo()
    {
        return $this->cuentaTipo;
    }

    /**
     * Set bancoNombre
     *
     * @param string $bancoNombre
     *
     * @return BpRegistroCompromiso
     */
    public function setBancoNombre($bancoNombre)
    {
        $this->bancoNombre = $bancoNombre;

        return $this;
    }

    /**
     * Get bancoNombre
     *
     * @return string
     */
    public function getBancoNombre()
    {
        return $this->bancoNombre;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return BpRegistroCompromiso
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
     * @return BpRegistroCompromiso
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
     * Set contratoNumero
     *
     * @param integer $contratoNumero
     *
     * @return BpRegistroCompromiso
     */
    public function setContratoNumero($contratoNumero)
    {
        $this->contratoNumero = $contratoNumero;

        return $this;
    }

    /**
     * Get contratoNumero
     *
     * @return int
     */
    public function getContratoNumero()
    {
        return $this->contratoNumero;
    }

    /**
     * Set contratoTipo
     *
     * @param string $contratoTipo
     *
     * @return BpRegistroCompromiso
     */
    public function setContratoTipo($contratoTipo)
    {
        $this->contratoTipo = $contratoTipo;

        return $this;
    }

    /**
     * Get contratoTipo
     *
     * @return string
     */
    public function getContratoTipo()
    {
        return $this->contratoTipo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return BpRegistroCompromiso
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpRegistroCompromiso
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
     * Set saldo
     *
     * @param integer $saldo
     *
     * @return BpRegistroCompromiso
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpRegistroCompromiso
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
     * Set cdp
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp
     *
     * @return BpRegistroCompromiso
     */
    public function setCdp(\JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp = null)
    {
        $this->cdp = $cdp;

        return $this;
    }

    /**
     * Get cdp
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpCdp
     */
    public function getCdp()
    {
        return $this->cdp;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return BpRegistroCompromiso
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return BpRegistroCompromiso
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
