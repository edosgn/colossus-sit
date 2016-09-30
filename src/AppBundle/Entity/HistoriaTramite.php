<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriaTramite
 *
 * @ORM\Table(name="historia_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HistoriaTramiteRepository")
 */
class HistoriaTramite
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
     * @ORM\Column(name="cupl", type="string", length=255)
     */
    private $cupl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date")
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoTramite", type="string", length=255)
     */
    private $estadoTramite;

    /**
     * @var int
     *
     * @ORM\Column(name="valorTramite", type="integer")
     */
    private $valorTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="licenciaTransito", type="string", length=255)
     */
    private $licenciaTransito;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroSustrato", type="integer")
     */
    private $numeroSustrato;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VarianteTramite", inversedBy="historialesTramite")
     **/
    protected $varianteTramite;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CuerpoTramite", inversedBy="historialesTramite")
     **/
    protected $cuerpoTramite;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="historialesTramite")
     **/
    protected $vehiculo;


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
     * Set cupl
     *
     * @param string $cupl
     *
     * @return HistoriaTramite
     */
    public function setCupl($cupl)
    {
        $this->cupl = $cupl;

        return $this;
    }

    /**
     * Get cupl
     *
     * @return string
     */
    public function getCupl()
    {
        return $this->cupl;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return HistoriaTramite
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
     * @return HistoriaTramite
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
     * Set estadoTramite
     *
     * @param string $estadoTramite
     *
     * @return HistoriaTramite
     */
    public function setEstadoTramite($estadoTramite)
    {
        $this->estadoTramite = $estadoTramite;

        return $this;
    }

    /**
     * Get estadoTramite
     *
     * @return string
     */
    public function getEstadoTramite()
    {
        return $this->estadoTramite;
    }

    /**
     * Set valorTramite
     *
     * @param integer $valorTramite
     *
     * @return HistoriaTramite
     */
    public function setValorTramite($valorTramite)
    {
        $this->valorTramite = $valorTramite;

        return $this;
    }

    /**
     * Get valorTramite
     *
     * @return integer
     */
    public function getValorTramite()
    {
        return $this->valorTramite;
    }

    /**
     * Set licenciaTransito
     *
     * @param string $licenciaTransito
     *
     * @return HistoriaTramite
     */
    public function setLicenciaTransito($licenciaTransito)
    {
        $this->licenciaTransito = $licenciaTransito;

        return $this;
    }

    /**
     * Get licenciaTransito
     *
     * @return string
     */
    public function getLicenciaTransito()
    {
        return $this->licenciaTransito;
    }

    /**
     * Set numeroSustrato
     *
     * @param integer $numeroSustrato
     *
     * @return HistoriaTramite
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
     * Set varianteTramite
     *
     * @param \AppBundle\Entity\VarianteTramite $varianteTramite
     *
     * @return HistoriaTramite
     */
    public function setVarianteTramite(\AppBundle\Entity\VarianteTramite $varianteTramite = null)
    {
        $this->varianteTramite = $varianteTramite;

        return $this;
    }

    /**
     * Get varianteTramite
     *
     * @return \AppBundle\Entity\VarianteTramite
     */
    public function getVarianteTramite()
    {
        return $this->varianteTramite;
    }

    /**
     * Set cuerpoTramite
     *
     * @param \AppBundle\Entity\CuerpoTramite $cuerpoTramite
     *
     * @return HistoriaTramite
     */
    public function setCuerpoTramite(\AppBundle\Entity\CuerpoTramite $cuerpoTramite = null)
    {
        $this->cuerpoTramite = $cuerpoTramite;

        return $this;
    }

    /**
     * Get cuerpoTramite
     *
     * @return \AppBundle\Entity\CuerpoTramite
     */
    public function getCuerpoTramite()
    {
        return $this->cuerpoTramite;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return HistoriaTramite
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
