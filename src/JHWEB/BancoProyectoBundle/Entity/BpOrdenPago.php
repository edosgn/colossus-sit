<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpOrdenPago
 *
 * @ORM\Table(name="bp_orden_pago")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpOrdenPagoRepository")
 */
class BpOrdenPago
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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="bigint")
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="text")
     */
    private $concepto;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="BpRegistroCompromiso")
     **/
    protected $registroCompromiso;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="ordenes") */
    private $autoriza;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BpOrdenPago
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return BpOrdenPago
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
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return BpOrdenPago
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return BpOrdenPago
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return BpOrdenPago
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpOrdenPago
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpOrdenPago
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
     * Set registroCompromiso
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso $registroCompromiso
     *
     * @return BpOrdenPago
     */
    public function setRegistroCompromiso(\JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso $registroCompromiso = null)
    {
        $this->registroCompromiso = $registroCompromiso;

        return $this;
    }

    /**
     * Get registroCompromiso
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso
     */
    public function getRegistroCompromiso()
    {
        return $this->registroCompromiso;
    }

    /**
     * Set autoriza
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $autoriza
     *
     * @return BpOrdenPago
     */
    public function setAutoriza(\JHWEB\PersonalBundle\Entity\PnalFuncionario $autoriza = null)
    {
        $this->autoriza = $autoriza;

        return $this;
    }

    /**
     * Get autoriza
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getAutoriza()
    {
        return $this->autoriza;
    }
}
