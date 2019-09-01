<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpReduccionCdp
 *
 * @ORM\Table(name="bp_reduccion_cdp")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpReduccionCdpRepository")
 */
class BpReduccionCdp
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
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacion", type="text")
     */
    private $justificacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="BpCdp")
     **/
    protected $cdp;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="reducciones") */
    private $solicita;


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
     * @return BpReduccionCdp
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpReduccionCdp
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
     * Set justificacion
     *
     * @param string $justificacion
     *
     * @return BpReduccionCdp
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;

        return $this;
    }

    /**
     * Get justificacion
     *
     * @return string
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpReduccionCdp
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
     * Set cdp
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp
     *
     * @return BpReduccionCdp
     */
    public function setCdp(\JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp = null)
    {
        $this->cdp = $cdp;

        return $this;
    }

    /**
     * Get cdp
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpCdp
     */
    public function getCdp()
    {
        return $this->cdp;
    }

    /**
     * Set solicita
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $solicita
     *
     * @return BpReduccionCdp
     */
    public function setSolicita(\JHWEB\PersonalBundle\Entity\PnalFuncionario $solicita = null)
    {
        $this->solicita = $solicita;

        return $this;
    }

    /**
     * Get solicita
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getSolicita()
    {
        return $this->solicita;
    }
}
