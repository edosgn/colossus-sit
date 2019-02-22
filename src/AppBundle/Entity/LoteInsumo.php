<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoteInsumo
 *
 * @ORM\Table(name="lote_insumo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoteInsumoRepository")
 */
class LoteInsumo
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
     * @var bool
     *
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroActa", type="string", length=255)
     */
    private $numeroActa; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="rangoInicio", type="string", length=255, nullable=true)
     */
    private $rangoInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="rangoFin", type="string", length=255, nullable=true)
     */
    private $rangoFin;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CasoInsumo")
     **/
    protected $casoInsumo;




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
     * Set estado
     *
     * @param string $estado
     *
     * @return LoteInsumo
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
     * Set numeroActa
     *
     * @param string $numeroActa
     *
     * @return LoteInsumo
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return LoteInsumo
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
     * Set rangoInicio
     *
     * @param string $rangoInicio
     *
     * @return LoteInsumo
     */
    public function setRangoInicio($rangoInicio)
    {
        $this->rangoInicio = $rangoInicio;

        return $this;
    }

    /**
     * Get rangoInicio
     *
     * @return string
     */
    public function getRangoInicio()
    {
        return $this->rangoInicio;
    }

    /**
     * Set rangoFin
     *
     * @param string $rangoFin
     *
     * @return LoteInsumo
     */
    public function setRangoFin($rangoFin)
    {
        $this->rangoFin = $rangoFin;

        return $this;
    }

    /**
     * Get rangoFin
     *
     * @return string
     */
    public function getRangoFin()
    {
        return $this->rangoFin;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return LoteInsumo
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return LoteInsumo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return LoteInsumo
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return LoteInsumo
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return LoteInsumo
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set casoInsumo
     *
     * @param \AppBundle\Entity\CasoInsumo $casoInsumo
     *
     * @return LoteInsumo
     */
    public function setCasoInsumo(\AppBundle\Entity\CasoInsumo $casoInsumo = null)
    {
        $this->casoInsumo = $casoInsumo;

        return $this;
    }

    /**
     * Get casoInsumo
     *
     * @return \AppBundle\Entity\CasoInsumo
     */
    public function getCasoInsumo()
    {
        return $this->casoInsumo;
    }
}
