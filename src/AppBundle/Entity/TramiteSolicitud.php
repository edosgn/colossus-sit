<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteSolicitud
 *
 * @ORM\Table(name="tramite_solicitud")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteSolicitudRepository")
 */
class TramiteSolicitud
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
     * @ORM\Column(name="fechaSolicitud", type="datetime")
     */
    private $fechaSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="Observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="documentacionCompleta", type="boolean")
     */
    private $documentacionCompleta;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="tramitesSolicitud")
     **/
    protected $factura;


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
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     *
     * @return TramiteSolicitud
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return TramiteSolicitud
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
     * Set documentacionCompleta
     *
     * @param boolean $documentacionCompleta
     *
     * @return TramiteSolicitud
     */
    public function setDocumentacionCompleta($documentacionCompleta)
    {
        $this->documentacionCompleta = $documentacionCompleta;

        return $this;
    }

    /**
     * Get documentacionCompleta
     *
     * @return boolean
     */
    public function getDocumentacionCompleta()
    {
        return $this->documentacionCompleta;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteSolicitud
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
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return TramiteSolicitud
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
