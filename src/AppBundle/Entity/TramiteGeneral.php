<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteGeneral
 *
 * @ORM\Table(name="tramite_general")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteGeneralRepository")
 */
class TramiteGeneral
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
     * @ORM\Column(name="numeroQpl", type="integer")
     */
    private $numeroQpl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date")
     */
    private $fechaFinal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroLicencia", type="integer")
     */
    private $numeroLicencia;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroSustrato", type="integer")
     */
    private $numeroSustrato;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="tramitesGeneral")
     **/
    protected $vehiculo;

 


    public function __toString()
    {
        return $this->getEstado();
    }

   

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
     * Set numeroQpl
     *
     * @param integer $numeroQpl
     *
     * @return TramiteGeneral
     */
    public function setNumeroQpl($numeroQpl)
    {
        $this->numeroQpl = $numeroQpl;

        return $this;
    }

    /**
     * Get numeroQpl
     *
     * @return integer
     */
    public function getNumeroQpl()
    {
        return $this->numeroQpl;
    }

    /**
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     *
     * @return TramiteGeneral
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = new \DateTime($fechaInicial);

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial->format('Y-m-d');
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return TramiteGeneral
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = new \DateTime($fechaFinal);

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal->format('Y-m-d');
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteGeneral
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return TramiteGeneral
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
     * Set numeroLicencia
     *
     * @param integer $numeroLicencia
     *
     * @return TramiteGeneral
     */
    public function setNumeroLicencia($numeroLicencia)
    {
        $this->numeroLicencia = $numeroLicencia;

        return $this;
    }

    /**
     * Get numeroLicencia
     *
     * @return integer
     */
    public function getNumeroLicencia()
    {
        return $this->numeroLicencia;
    }

    /**
     * Set numeroSustrato
     *
     * @param integer $numeroSustrato
     *
     * @return TramiteGeneral
     */
    public function setNumeroSustrato($numeroSustrato)
    {
        $this->numeroSustrato = $numeroSustrato;

        return $this;
    }

    /**
     * Get numeroSustrato
     *
     * @return integer
     */
    public function getNumeroSustrato()
    {
        return $this->numeroSustrato;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return TramiteGeneral
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
