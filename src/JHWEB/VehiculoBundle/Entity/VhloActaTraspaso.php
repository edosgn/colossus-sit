<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloActaTraspaso
 *
 * @ORM\Table(name="vhlo_acta_traspaso")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloActaTraspasoRepository")
 */
class VhloActaTraspaso
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TramiteSolicitud")
     */
    private $tramiteSolicitud; 

    /**
     * @ORM\OneToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgEntidadJudicial")
     */
    private $entidadJudicial; 
 
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return VhloActaTraspaso
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
     * Set numero
     *
     * @param string $numero
     *
     * @return VhloActaTraspaso
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
     * Set tramiteSolicitud
     *
     * @param \AppBundle\Entity\TramiteSolicitud $tramiteSolicitud
     *
     * @return VhloActaTraspaso
     */
    public function setTramiteSolicitud(\AppBundle\Entity\TramiteSolicitud $tramiteSolicitud = null)
    {
        $this->tramiteSolicitud = $tramiteSolicitud;

        return $this;
    }

    /**
     * Get tramiteSolicitud
     *
     * @return \AppBundle\Entity\TramiteSolicitud
     */
    public function getTramiteSolicitud()
    {
        return $this->tramiteSolicitud;
    }

    /**
     * Set entidadJudicial
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgEntidadJudicial $entidadJudicial
     *
     * @return VhloActaTraspaso
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
}
