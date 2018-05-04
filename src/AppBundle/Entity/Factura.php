<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="factura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacturaRepository")
 */
class Factura
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
     * @ORM\Column(name="numero", type="string", length=45)
     */
    private $numero;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var float
     *
     * @ORM\Column(name="valorBruto", type="float")
     */
    private $valorBruto = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="valorImpuesto", type="float")
     */
    private $valorImpuesto = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="valorNeto", type="float")
     */
    private $valorNeto = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="numeroLicenciaTrancito", type="string", length=45)
     */
    private $numeroLicenciaTrancito;
    

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="facturas")
     **/
    protected $sedeOperativa;


    

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
     * Set numero
     *
     * @param string $numero
     *
     * @return Factura
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
     * @param boolean $estado
     *
     * @return Factura
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Factura
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
        return $this->fechaCreacion->format('Y-m-d');
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Factura
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set valorBruto
     *
     * @param float $valorBruto
     *
     * @return Factura
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
     * Set valorImpuesto
     *
     * @param float $valorImpuesto
     *
     * @return Factura
     */
    public function setValorImpuesto($valorImpuesto)
    {
        $this->valorImpuesto = $valorImpuesto;

        return $this;
    }

    /**
     * Get valorImpuesto
     *
     * @return float
     */
    public function getValorImpuesto()
    {
        return $this->valorImpuesto;
    }

    /**
     * Set valorNeto
     *
     * @param float $valorNeto
     *
     * @return Factura
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
     * Set numeroLicenciaTrancito
     *
     * @param string $numeroLicenciaTrancito
     *
     * @return Factura
     */
    public function setNumeroLicenciaTrancito($numeroLicenciaTrancito)
    {
        $this->numeroLicenciaTrancito = $numeroLicenciaTrancito;

        return $this;
    }

    /**
     * Get numeroLicenciaTrancito
     *
     * @return string
     */
    public function getNumeroLicenciaTrancito()
    {
        return $this->numeroLicenciaTrancito;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return Factura
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
}
