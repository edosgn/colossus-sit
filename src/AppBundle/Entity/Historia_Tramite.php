<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historia_Tramite
 *
 * @ORM\Table(name="historia__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Historia_TramiteRepository")
 */
class Historia_Tramite
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
     * @return Historia_Tramite
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
     * @return Historia_Tramite
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
     * @return Historia_Tramite
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
     * @return Historia_Tramite
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
     * @return Historia_Tramite
     */
    public function setValorTramite($valorTramite)
    {
        $this->valorTramite = $valorTramite;

        return $this;
    }

    /**
     * Get valorTramite
     *
     * @return int
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
     * @return Historia_Tramite
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
     * @return Historia_Tramite
     */
    public function setNumeroSustrato($numeroSustrato)
    {
        $this->numeroSustrato = $numeroSustrato;

        return $this;
    }

    /**
     * Get numeroSustrato
     *
     * @return int
     */
    public function getNumeroSustrato()
    {
        return $this->numeroSustrato;
    }
}

