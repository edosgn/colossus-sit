<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvMedidaCautelar
 *
 * @ORM\Table(name="cv_medida_cautelar")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvMedidaCautelarRepository")
 */
class CvMedidaCautelar
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
     * @ORM\Column(name="fechaRegistro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInico", type="date")
     */
    private $fechaInico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaExpiracion", type="date")
     */
    private $fechaExpiracion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaLevantamiento", type="date", nullable=true)
     */
    private $fechaLevantamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroOficioInscripcion", type="integer", nullable=true)
     */
    private $numeroOficioInscripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroOficioLevantamiento", type="integer")
     */
    private $numeroOficioLevantamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroRadicado", type="integer")
     */
    private $numeroRadicado;

    /**
     * @var string
     *
     * @ORM\Column(name="observacionesInscripcion", type="text")
     */
    private $observacionesInscripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacionesLevantamiento", type="text", nullable=true)
     */
    private $observacionesLevantamiento;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="notificaciones") */
    private $municipioInscripcion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="notificaciones") */
    private $municipioLevantamiento;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="facturas")
     **/
    protected $entidadJudicialInscripcion; 

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="facturas")
     **/
    protected $entidadJudicialLevantamiento; 

    /**
     * @ORM\ManyToOne(targetEntity="CvCfgTipoMedidaCautelar", inversedBy="facturas")
     **/
    protected $tipoMedidaCautelar; 
    

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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return CvMedidaCautelar
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
     * Set fechaInico
     *
     * @param \DateTime $fechaInico
     *
     * @return CvMedidaCautelar
     */
    public function setFechaInico($fechaInico)
    {
        $this->fechaInico = $fechaInico;

        return $this;
    }

    /**
     * Get fechaInico
     *
     * @return \DateTime
     */
    public function getFechaInico()
    {
        return $this->fechaInico;
    }

    /**
     * Set fechaExpiracion
     *
     * @param \DateTime $fechaExpiracion
     *
     * @return CvMedidaCautelar
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fechaExpiracion = $fechaExpiracion;

        return $this;
    }

    /**
     * Get fechaExpiracion
     *
     * @return \DateTime
     */
    public function getFechaExpiracion()
    {
        return $this->fechaExpiracion;
    }

    /**
     * Set fechaLevantamiento
     *
     * @param \DateTime $fechaLevantamiento
     *
     * @return CvMedidaCautelar
     */
    public function setFechaLevantamiento($fechaLevantamiento)
    {
        $this->fechaLevantamiento = $fechaLevantamiento;

        return $this;
    }

    /**
     * Get fechaLevantamiento
     *
     * @return \DateTime
     */
    public function getFechaLevantamiento()
    {
        return $this->fechaLevantamiento;
    }

    /**
     * Set numeroOficioInscripcion
     *
     * @param integer $numeroOficioInscripcion
     *
     * @return CvMedidaCautelar
     */
    public function setNumeroOficioInscripcion($numeroOficioInscripcion)
    {
        $this->numeroOficioInscripcion = $numeroOficioInscripcion;

        return $this;
    }

    /**
     * Get numeroOficioInscripcion
     *
     * @return integer
     */
    public function getNumeroOficioInscripcion()
    {
        return $this->numeroOficioInscripcion;
    }

    /**
     * Set numeroOficioLevantamiento
     *
     * @param integer $numeroOficioLevantamiento
     *
     * @return CvMedidaCautelar
     */
    public function setNumeroOficioLevantamiento($numeroOficioLevantamiento)
    {
        $this->numeroOficioLevantamiento = $numeroOficioLevantamiento;

        return $this;
    }

    /**
     * Get numeroOficioLevantamiento
     *
     * @return integer
     */
    public function getNumeroOficioLevantamiento()
    {
        return $this->numeroOficioLevantamiento;
    }

    /**
     * Set numeroRadicado
     *
     * @param integer $numeroRadicado
     *
     * @return CvMedidaCautelar
     */
    public function setNumeroRadicado($numeroRadicado)
    {
        $this->numeroRadicado = $numeroRadicado;

        return $this;
    }

    /**
     * Get numeroRadicado
     *
     * @return integer
     */
    public function getNumeroRadicado()
    {
        return $this->numeroRadicado;
    }

    /**
     * Set observacionesInscripcion
     *
     * @param string $observacionesInscripcion
     *
     * @return CvMedidaCautelar
     */
    public function setObservacionesInscripcion($observacionesInscripcion)
    {
        $this->observacionesInscripcion = $observacionesInscripcion;

        return $this;
    }

    /**
     * Get observacionesInscripcion
     *
     * @return string
     */
    public function getObservacionesInscripcion()
    {
        return $this->observacionesInscripcion;
    }

    /**
     * Set observacionesLevantamiento
     *
     * @param string $observacionesLevantamiento
     *
     * @return CvMedidaCautelar
     */
    public function setObservacionesLevantamiento($observacionesLevantamiento)
    {
        $this->observacionesLevantamiento = $observacionesLevantamiento;

        return $this;
    }

    /**
     * Get observacionesLevantamiento
     *
     * @return string
     */
    public function getObservacionesLevantamiento()
    {
        return $this->observacionesLevantamiento;
    }

    /**
     * Set municipioInscripcion
     *
     * @param \AppBundle\Entity\Municipio $municipioInscripcion
     *
     * @return CvMedidaCautelar
     */
    public function setMunicipioInscripcion(\AppBundle\Entity\Municipio $municipioInscripcion = null)
    {
        $this->municipioInscripcion = $municipioInscripcion;

        return $this;
    }

    /**
     * Get municipioInscripcion
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioInscripcion()
    {
        return $this->municipioInscripcion;
    }

    /**
     * Set municipioLevantamiento
     *
     * @param \AppBundle\Entity\Municipio $municipioLevantamiento
     *
     * @return CvMedidaCautelar
     */
    public function setMunicipioLevantamiento(\AppBundle\Entity\Municipio $municipioLevantamiento = null)
    {
        $this->municipioLevantamiento = $municipioLevantamiento;

        return $this;
    }

    /**
     * Get municipioLevantamiento
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioLevantamiento()
    {
        return $this->municipioLevantamiento;
    }

    /**
     * Set entidadJudicialInscripcion
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialInscripcion
     *
     * @return CvMedidaCautelar
     */
    public function setEntidadJudicialInscripcion(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialInscripcion = null)
    {
        $this->entidadJudicialInscripcion = $entidadJudicialInscripcion;

        return $this;
    }

    /**
     * Get entidadJudicialInscripcion
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicialInscripcion()
    {
        return $this->entidadJudicialInscripcion;
    }

    /**
     * Set entidadJudicialLevantamiento
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialLevantamiento
     *
     * @return CvMedidaCautelar
     */
    public function setEntidadJudicialLevantamiento(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicialLevantamiento = null)
    {
        $this->entidadJudicialLevantamiento = $entidadJudicialLevantamiento;

        return $this;
    }

    /**
     * Get entidadJudicialLevantamiento
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicialLevantamiento()
    {
        return $this->entidadJudicialLevantamiento;
    }

    /**
     * Set tipoMedidaCautelar
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgTipoMedidaCautelar $tipoMedidaCautelar
     *
     * @return CvMedidaCautelar
     */
    public function setTipoMedidaCautelar(\JHWEB\ContravencionalBundle\Entity\CvCfgTipoMedidaCautelar $tipoMedidaCautelar = null)
    {
        $this->tipoMedidaCautelar = $tipoMedidaCautelar;

        return $this;
    }

    /**
     * Get tipoMedidaCautelar
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgTipoMedidaCautelar
     */
    public function getTipoMedidaCautelar()
    {
        return $this->tipoMedidaCautelar;
    }
}
