<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatImpresoMunicipio
 *
 * @ORM\Table(name="sv_ipat_impreso_municipio")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatImpresoMunicipioRepository")
 */
class SvIpatImpresoMunicipio
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
     * @ORM\Column(name="numero_acta", type="string", length=255, nullable=true)
     */
    private $numeroActa;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad_disponible", type="integer")
     */
    private $cantidadDisponible;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad_entregada", type="integer")
     */
    private $cantidadEntregada;

    /**
     * @var string
     *
     * @ORM\Column(name="corregimiento", type="string", length=255, nullable=true)
     */
    private $corregimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable_nombre", type="string", length=255, nullable=true)
     */
    private $responsableNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="responsable_identificacion", type="integer", nullable=false)
     */
    private $responsableIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable_cargo", type="string", length=255, nullable=true)
     */
    private $responsableCargo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="municipios")
     */
    private $organismoTransito;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="municipios")
     */
    private $municipio;


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
     * Set numeroActa
     *
     * @param string $numeroActa
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setNumeroActa($numeroActa)
    {
        $this->numeroActa = $numeroActa;

        return $this;
    }

    /**
     * Get numeroActa
     *
     * @return string
     */
    public function getNumeroActa()
    {
        return $this->numeroActa;
    }

    /**
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvIpatImpresoMunicipio
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
        if ($this->fecha) {
            return $this->fecha->format('d/m/Y');
        }
        return $this->fecha;
    }

    /**
     * Set cantidadDisponible
     *
     * @param integer $cantidadDisponible
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setCantidadDisponible($cantidadDisponible)
    {
        $this->cantidadDisponible = $cantidadDisponible;

        return $this;
    }

    /**
     * Get cantidadDisponible
     *
     * @return integer
     */
    public function getCantidadDisponible()
    {
        return $this->cantidadDisponible;
    }

    /**
     * Set cantidadEntregada
     *
     * @param integer $cantidadEntregada
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setCantidadEntregada($cantidadEntregada)
    {
        $this->cantidadEntregada = $cantidadEntregada;

        return $this;
    }

    /**
     * Get cantidadEntregada
     *
     * @return integer
     */
    public function getCantidadEntregada()
    {
        return $this->cantidadEntregada;
    }

    /**
     * Set corregimiento
     *
     * @param string $corregimiento
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setCorregimiento($corregimiento)
    {
        $this->corregimiento = $corregimiento;

        return $this;
    }

    /**
     * Get corregimiento
     *
     * @return string
     */
    public function getCorregimiento()
    {
        return $this->corregimiento;
    }

    /**
     * Set responsableNombre
     *
     * @param string $responsableNombre
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setResponsableNombre($responsableNombre)
    {
        $this->responsableNombre = $responsableNombre;

        return $this;
    }

    /**
     * Get responsableNombre
     *
     * @return string
     */
    public function getResponsableNombre()
    {
        return $this->responsableNombre;
    }

    /**
     * Set responsableIdentificacion
     *
     * @param integer $responsableIdentificacion
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setResponsableIdentificacion($responsableIdentificacion)
    {
        $this->responsableIdentificacion = $responsableIdentificacion;

        return $this;
    }

    /**
     * Get responsableIdentificacion
     *
     * @return integer
     */
    public function getResponsableIdentificacion()
    {
        return $this->responsableIdentificacion;
    }

    /**
     * Set responsableCargo
     *
     * @param string $responsableCargo
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setResponsableCargo($responsableCargo)
    {
        $this->responsableCargo = $responsableCargo;

        return $this;
    }

    /**
     * Get responsableCargo
     *
     * @return string
     */
    public function getResponsableCargo()
    {
        return $this->responsableCargo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatImpresoMunicipio
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return SvIpatImpresoMunicipio
     */
    public function setMunicipio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
