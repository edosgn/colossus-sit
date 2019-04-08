<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatAsignacion
 *
 * @ORM\Table(name="sv_ipat_asignacion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatAsignacionRepository")
 */
class SvIpatAsignacion
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
     * @ORM\Column(name="rango_inicial", type="bigint")
     */
    private $rangoInicial;

    /**
     * @var int
     *
     * @ORM\Column(name="rango_final", type="bigint")
     */
    private $rangoFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_acta", type="string", length=100)
     */
    private $numeroActa;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="SvIpatTalonario", inversedBy="asignaciones")
     **/
    protected $talonario;

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
     * @return SvIpatAsignacion
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
     * @return SvIpatAsignacion
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
     * @return SvIpatAsignacion
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvIpatAsignacion
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
     * Set numeroActa
     *
     * @param string $numeroActa
     *
     * @return SvIpatAsignacion
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatAsignacion
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
     * Set talonario
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario $talonario
     *
     * @return SvIpatAsignacion
     */
    public function setTalonario(\JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario $talonario = null)
    {
        $this->talonario = $talonario;

        return $this;
    }

    /**
     * Get talonario
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario
     */
    public function getTalonario()
    {
        return $this->talonario;
    }
}
