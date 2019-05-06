<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoLote
 *
 * @ORM\Table(name="imo_lote")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoLoteRepository")
 */
class ImoLote
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
     * @ORM\Column(name="numero_acta", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="rango_inicio", type="string", length=255, nullable=true)
     */
    private $rangoInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="rango_fin", type="string", length=255, nullable=true)
     */
    private $rangoFin;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255, nullable=true)
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
     * @var int
     *
     * @ORM\Column(name="recibido", type="integer")
     */
    private $recibido;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa")
     **/
    protected $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="ImoCfgTipo")
     **/
    protected $tipoInsumo;   

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
     * @return ImoLote
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
     * @return ImoLote
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
     * @return ImoLote
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
            return $this->fecha->format('Y-m-d');
        }
        return $this->fecha;
    }

    /**
     * Set rangoInicio
     *
     * @param string $rangoInicio
     *
     * @return ImoLote
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
     * @return ImoLote
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
     * @return ImoLote
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
     * @return ImoLote
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
     * @return ImoLote
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
     * Set recibido
     *
     * @param integer $recibido
     *
     * @return ImoLote
     */
    public function setRecibido($recibido)
    {
        $this->recibido = $recibido;

        return $this;
    }

    /**
     * Get recibido
     *
     * @return integer
     */
    public function getRecibido()
    {
        return $this->recibido;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return ImoLote
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set sedeOperativa
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $sedeOperativa
     *
     * @return ImoLote
     */
    public function setSedeOperativa(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set tipoInsumo
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoCfgTipo $tipoInsumo
     *
     * @return ImoLote
     */
    public function setTipoInsumo(\JHWEB\InsumoBundle\Entity\ImoCfgTipo $tipoInsumo = null)
    {
        $this->tipoInsumo = $tipoInsumo;

        return $this;
    }

    /**
     * Get tipoInsumo
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoCfgTipo
     */
    public function getTipoInsumo()
    {
        return $this->tipoInsumo;
    }
}
