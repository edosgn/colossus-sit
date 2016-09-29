<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CuentaRepository")
 */
class Cuenta
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
     * @ORM\Column(name="datosCuenta", type="string", length=255)
     */
    private $datosCuenta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Banco", inversedBy="cuentas")
     **/
    protected $banco;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Conceptos_Tramite", mappedBy="cuenta")
     **/
    protected $conceptosTramite;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pago_Tramite", mappedBy="cuenta")
     **/
    protected $pagosTramite;


    public function __construct() {
        $this->conceptosTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagosTramite = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set datosCuenta
     *
     * @param string $datosCuenta
     *
     * @return Cuenta
     */
    public function setDatosCuenta($datosCuenta)
    {
        $this->datosCuenta = $datosCuenta;

        return $this;
    }

    /**
     * Get datosCuenta
     *
     * @return string
     */
    public function getDatosCuenta()
    {
        return $this->datosCuenta;
    }

    /**
     * Set banco
     *
     * @param \AppBundle\Entity\Banco $banco
     *
     * @return Cuenta
     */
    public function setBanco(\AppBundle\Entity\Banco $banco = null)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return \AppBundle\Entity\Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Add conceptosTramite
     *
     * @param \AppBundle\Entity\Conceptos_Tramite $conceptosTramite
     *
     * @return Cuenta
     */
    public function addConceptosTramite(\AppBundle\Entity\Conceptos_Tramite $conceptosTramite)
    {
        $this->conceptosTramite[] = $conceptosTramite;

        return $this;
    }

    /**
     * Remove conceptosTramite
     *
     * @param \AppBundle\Entity\Conceptos_Tramite $conceptosTramite
     */
    public function removeConceptosTramite(\AppBundle\Entity\Conceptos_Tramite $conceptosTramite)
    {
        $this->conceptosTramite->removeElement($conceptosTramite);
    }

    /**
     * Get conceptosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptosTramite()
    {
        return $this->conceptosTramite;
    }

    /**
     * Add pagosTramite
     *
     * @param \AppBundle\Entity\Pago_Tramite $pagosTramite
     *
     * @return Cuenta
     */
    public function addPagosTramite(\AppBundle\Entity\Pago_Tramite $pagosTramite)
    {
        $this->pagosTramite[] = $pagosTramite;

        return $this;
    }

    /**
     * Remove pagosTramite
     *
     * @param \AppBundle\Entity\Pago_Tramite $pagosTramite
     */
    public function removePagosTramite(\AppBundle\Entity\Pago_Tramite $pagosTramite)
    {
        $this->pagosTramite->removeElement($pagosTramite);
    }

    /**
     * Get pagosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagosTramite()
    {
        return $this->pagosTramite;
    }
}
