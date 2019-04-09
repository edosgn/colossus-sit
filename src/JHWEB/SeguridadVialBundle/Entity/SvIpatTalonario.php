<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatTalonario
 *
 * @ORM\Table(name="sv_ipat_talonario")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatTalonarioRepository")
 */
class SvIpatTalonario
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
     * @ORM\Column(name="rango_inicial", type="integer")
     */
    private $rangoInicial;

    /**
     * @var int
     *
     * @ORM\Column(name="rango_final", type="integer")
     */
    private $rangoFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="disponible", type="integer")
     */
    private $disponible;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_resolucion", type="string", length=255)
     */
    private $numeroResolucion;

    /** 
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="talonarios")
     **/
    protected $organismoTransito;


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
     * Set rangoInicial
     *
     * @param integer $rangoInicial
     *
     * @return SvIpatTalonario
     */
    public function setRangoInicial($rangoInicial)
    {
        $this->rangoInicial = $rangoInicial;

        return $this;
    }

    /**
     * Get rangoInicial
     *
     * @return integer
     */
    public function getRangoInicial()
    {
        return $this->rangoInicial;
    }

    /**
     * Set rangoFinal
     *
     * @param integer $rangoFinal
     *
     * @return SvIpatTalonario
     */
    public function setRangoFinal($rangoFinal)
    {
        $this->rangoFinal = $rangoFinal;

        return $this;
    }

    /**
     * Get rangoFinal
     *
     * @return integer
     */
    public function getRangoFinal()
    {
        return $this->rangoFinal;
    }

    /**
     * Set total
     *
     * @param integer $total
     *
     * @return SvIpatTalonario
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set disponible
     *
     * @param integer $disponible
     *
     * @return SvIpatTalonario
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return integer
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvIpatTalonario
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
     * Set numeroResolucion
     *
     * @param string $numeroResolucion
     *
     * @return SvIpatTalonario
     */
    public function setNumeroResolucion($numeroResolucion)
    {
        $this->numeroResolucion = $numeroResolucion;

        return $this;
    }

    /**
     * Get numeroResolucion
     *
     * @return string
     */
    public function getNumeroResolucion()
    {
        return $this->numeroResolucion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatTalonario
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
     * @return SvIpatTalonario
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
}
