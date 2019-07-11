<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoTrazabilidad
 *
 * @ORM\Table(name="imo_trazabilidad")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoTrazabilidadRepository")
 */
class ImoTrazabilidad
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255) 
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="trazabilidades")
     **/
    protected $organismoTransitoOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="trazabilidades")
     **/
    protected $organismoTransitoDestino;

    /** @ORM\ManyToOne(targetEntity="ImoLote", inversedBy="trazabilidades") */
    private $lote;

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
     * @return ImoTrazabilidad
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
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return ImoTrazabilidad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return ImoTrazabilidad
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ImoTrazabilidad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set organismoTransitoOrigen
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoOrigen
     *
     * @return ImoTrazabilidad
     */
    public function setOrganismoTransitoOrigen(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoOrigen = null)
    {
        $this->organismoTransitoOrigen = $organismoTransitoOrigen;

        return $this;
    }

    /**
     * Get organismoTransitoOrigen
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransitoOrigen()
    {
        return $this->organismoTransitoOrigen;
    }

    /**
     * Set organismoTransitoDestino
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoDestino
     *
     * @return ImoTrazabilidad
     */
    public function setOrganismoTransitoDestino(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransitoDestino = null)
    {
        $this->organismoTransitoDestino = $organismoTransitoDestino;

        return $this;
    }

    /**
     * Get organismoTransitoDestino
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransitoDestino()
    {
        return $this->organismoTransitoDestino;
    }

    /**
     * Set lote
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoLote $lote
     *
     * @return ImoTrazabilidad
     */
    public function setLote(\JHWEB\InsumoBundle\Entity\ImoLote $lote = null)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoLote
     */
    public function getLote()
    {
        return $this->lote;
    }
}
