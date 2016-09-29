<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago_Tramite
 *
 * @ORM\Table(name="pago__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Pago_TramiteRepository")
 */
class Pago_Tramite
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
     * @ORM\Column(name="valorPago", type="integer")
     */
    private $valorPago; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPago", type="datetime")
     */
    private $fechaPago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaPago", type="time")
     */
    private $horaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoPago", type="string", length=255)
     */
    private $estadoPago; 


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cuenta", inversedBy="pagosTramite")
     **/
    protected $cuenta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cuerpo_Tramite", inversedBy="pagosTramite")
     **/
    protected $cuerpoTramite;


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
     * Set valorPago
     *
     * @param integer $valorPago
     *
     * @return Pago_Tramite
     */
    public function setValorPago($valorPago)
    {
        $this->valorPago = $valorPago;

        return $this;
    }

    /**
     * Get valorPago
     *
     * @return integer
     */
    public function getValorPago()
    {
        return $this->valorPago;
    }

    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return Pago_Tramite
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
     * @return Pago_Tramite
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
     * Set estadoPago
     *
     * @param string $estadoPago
     *
     * @return Pago_Tramite
     */
    public function setEstadoPago($estadoPago)
    {
        $this->estadoPago = $estadoPago;

        return $this;
    }

    /**
     * Get estadoPago
     *
     * @return string
     */
    public function getEstadoPago()
    {
        return $this->estadoPago;
    }

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Pago_Tramite
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \AppBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set cuerpoTramite
     *
     * @param \AppBundle\Entity\Cuerpo_Tramite $cuerpoTramite
     *
     * @return Pago_Tramite
     */
    public function setCuerpoTramite(\AppBundle\Entity\Cuerpo_Tramite $cuerpoTramite = null)
    {
        $this->cuerpoTramite = $cuerpoTramite;

        return $this;
    }

    /**
     * Get cuerpoTramite
     *
     * @return \AppBundle\Entity\Cuerpo_Tramite
     */
    public function getCuerpoTramite()
    {
        return $this->cuerpoTramite;
    }
}
