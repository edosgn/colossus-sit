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
     * @var int
     *
     * @ORM\Column(name="numeroOficio", type="integer")
     */
    private $numeroOficio;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroRadicado", type="integer")
     */
    private $numeroRadicado;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="notificaciones") */
    private $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial", inversedBy="facturas")
     **/
    protected $entidadJudicial; 

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
     * Set numeroOficio
     *
     * @param integer $numeroOficio
     *
     * @return CvMedidaCautelar
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return integer
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CvMedidaCautelar
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return CvMedidaCautelar
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set entidadJudicial
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial
     *
     * @return CvMedidaCautelar
     */
    public function setEntidadJudicial(\JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial = null)
    {
        $this->entidadJudicial = $entidadJudicial;

        return $this;
    }

    /**
     * Get entidadJudicial
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicial()
    {
        return $this->entidadJudicial;
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
