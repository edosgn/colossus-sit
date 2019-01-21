<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpCdp
 *
 * @ORM\Table(name="bp_cdp")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpCdpRepository")
 */
class BpCdp
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
     * @ORM\Column(name="solicitud_numero", type="bigint")
     */
    private $solicitudNumero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="solicitud_fecha", type="date")
     */
    private $solicitudFecha;

    /**
     * @var int
     *
     * @ORM\Column(name="solicitud_consecutivo", type="integer")
     */
    private $solicitudConsecutivo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="bigint")
     */
    private $numero;

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
     * @ORM\ManyToOne(targetEntity="BpActividad")
     **/
    protected $actividad;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return BpCdp
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpCdp
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return int
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
     * @return BpCdp
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set actividad
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad
     *
     * @return BpCdp
     */
    public function setActividad(\JHWEB\BancoProyectoBundle\Entity\BpActividad $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpActividad
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set solicitudNumero
     *
     * @param integer $solicitudNumero
     *
     * @return BpCdp
     */
    public function setSolicitudNumero($solicitudNumero)
    {
        $this->solicitudNumero = $solicitudNumero;

        return $this;
    }

    /**
     * Get solicitudNumero
     *
     * @return integer
     */
    public function getSolicitudNumero()
    {
        return $this->solicitudNumero;
    }

    /**
     * Set solicitudFecha
     *
     * @param \DateTime $solicitudFecha
     *
     * @return BpCdp
     */
    public function setSolicitudFecha($solicitudFecha)
    {
        $this->solicitudFecha = $solicitudFecha;

        return $this;
    }

    /**
     * Get solicitudFecha
     *
     * @return \DateTime
     */
    public function getSolicitudFecha()
    {
        return $this->solicitudFecha;
    }

    /**
     * Set solicitudConsecutivo
     *
     * @param integer $solicitudConsecutivo
     *
     * @return BpCdp
     */
    public function setSolicitudConsecutivo($solicitudConsecutivo)
    {
        $this->solicitudConsecutivo = $solicitudConsecutivo;

        return $this;
    }

    /**
     * Get solicitudConsecutivo
     *
     * @return integer
     */
    public function getSolicitudConsecutivo()
    {
        return $this->solicitudConsecutivo;
    }
}
