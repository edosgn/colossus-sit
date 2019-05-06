<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFactura
 *
 * @ORM\Table(name="fro_factura")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacturaRepository")
 */
class FroFactura
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="date", nullable=true)
     */
    private $fechaPago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_pago", type="time", nullable=true)
     */
    private $horaPago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_bruto", type="float")
     */
    private $valorBruto;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_mora", type="float")
     */
    private $valorMora;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_neto", type="float")
     */
    private $valorNeto;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=50)
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroRunt", type="string", length=50, nullable=true)
     */
    private $numeroRunt;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="facturas")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="FroCfgTipoRecaudo", inversedBy="facturas")
     **/
    protected $tipoRecaudo;


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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return FroFactura
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return FroFactura
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return FroFactura
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set horaPago
     *
     * @param \DateTime $horaPago
     *
     * @return FroFactura
     */
    public function setHoraPago($horaPago)
    {
        $this->horaPago = $horaPago;

        return $this;
    }

    /**
     * Get horaPago
     *
     * @return \DateTime
     */
    public function getHoraPago()
    {
        return $this->horaPago;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return FroFactura
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set valorBruto
     *
     * @param float $valorBruto
     *
     * @return FroFactura
     */
    public function setValorBruto($valorBruto)
    {
        $this->valorBruto = $valorBruto;

        return $this;
    }

    /**
     * Get valorBruto
     *
     * @return float
     */
    public function getValorBruto()
    {
        return $this->valorBruto;
    }

    /**
     * Set valorMora
     *
     * @param float $valorMora
     *
     * @return FroFactura
     */
    public function setValorMora($valorMora)
    {
        $this->valorMora = $valorMora;

        return $this;
    }

    /**
     * Get valorMora
     *
     * @return float
     */
    public function getValorMora()
    {
        return $this->valorMora;
    }

    /**
     * Set valorNeto
     *
     * @param float $valorNeto
     *
     * @return FroFactura
     */
    public function setValorNeto($valorNeto)
    {
        $this->valorNeto = $valorNeto;

        return $this;
    }

    /**
     * Get valorNeto
     *
     * @return float
     */
    public function getValorNeto()
    {
        return $this->valorNeto;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return FroFactura
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
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return FroFactura
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return FroFactura
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
     * Set numeroRunt
     *
     * @param string $numeroRunt
     *
     * @return FroFactura
     */
    public function setNumeroRunt($numeroRunt)
    {
        $this->numeroRunt = $numeroRunt;

        return $this;
    }

    /**
     * Get numeroRunt
     *
     * @return string
     */
    public function getNumeroRunt()
    {
        return $this->numeroRunt;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroFactura
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return FroFactura
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }

    /**
     * Set tipoRecaudo
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroCfgTipoRecaudo $tipoRecaudo
     *
     * @return FroFactura
     */
    public function setTipoRecaudo(\JHWEB\FinancieroBundle\Entity\FroCfgTipoRecaudo $tipoRecaudo = null)
    {
        $this->tipoRecaudo = $tipoRecaudo;

        return $this;
    }

    /**
     * Get tipoRecaudo
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroCfgTipoRecaudo
     */
    public function getTipoRecaudo()
    {
        return $this->tipoRecaudo;
    }
}
