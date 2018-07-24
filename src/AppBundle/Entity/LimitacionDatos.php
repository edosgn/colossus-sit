<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LimitacionDatos
 *
 * @ORM\Table(name="limitacion_datos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LimitacionDatosRepository")
 */
class LimitacionDatos
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
     * @ORM\Column(name="fechaRadicacion", type="date")
     */
    private $fechaRadicacion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="placas")
     **/
    protected $departamento;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="placas")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $ciudadanoDemandado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $ciudadanoDemandante;

    /**
     * @var string
     *
     * @ORM\Column(name="ordenJudicial", type="string", length=45)
     */
    private $nOrdenJudicial;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgLimitacion", inversedBy="facturas")
     **/
    protected $limitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaExpedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoProceso", inversedBy="facturas")
     **/
    protected $tipoProceso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgEntidadJudicial", inversedBy="facturas")
     **/
    protected $entidadJudicial;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

    /**
     * @var array
     *
     * @ORM\Column(name="datos", type="array")
     */
    private $datos;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

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
     * Set fechaRadicacion
     *
     * @param \DateTime $fechaRadicacion
     *
     * @return LimitacionDatos
     */
    public function setFechaRadicacion($fechaRadicacion)
    {
        $this->fechaRadicacion = $fechaRadicacion;

        return $this;
    }

    /**
     * Get fechaRadicacion
     *
     * @return \DateTime
     */
    public function getFechaRadicacion()
    {
        return $this->fechaRadicacion;
    }

    /**
     * Set nOrdenJudicial
     *
     * @param string $nOrdenJudicial
     *
     * @return LimitacionDatos
     */
    public function setNOrdenJudicial($nOrdenJudicial)
    {
        $this->nOrdenJudicial = $nOrdenJudicial;

        return $this;
    }

    /**
     * Get nOrdenJudicial
     *
     * @return string
     */
    public function getNOrdenJudicial()
    {
        return $this->nOrdenJudicial;
    }

    /**
     * Set fechaExpedicion
     *
     * @param \DateTime $fechaExpedicion
     *
     * @return LimitacionDatos
     */
    public function setFechaExpedicion($fechaExpedicion)
    {
        $this->fechaExpedicion = $fechaExpedicion;

        return $this;
    }

    /**
     * Get fechaExpedicion
     *
     * @return \DateTime
     */
    public function getFechaExpedicion()
    {
        return $this->fechaExpedicion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return LimitacionDatos
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set datos
     *
     * @param array $datos
     *
     * @return LimitacionDatos
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return LimitacionDatos
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
     * Set departamento
     *
     * @param \AppBundle\Entity\Departamento $departamento
     *
     * @return LimitacionDatos
     */
    public function setDepartamento(\AppBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return LimitacionDatos
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set ciudadanoDemandado
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadanoDemandado
     *
     * @return LimitacionDatos
     */
    public function setCiudadanoDemandado(\AppBundle\Entity\Ciudadano $ciudadanoDemandado = null)
    {
        $this->ciudadanoDemandado = $ciudadanoDemandado;

        return $this;
    }

    /**
     * Get ciudadanoDemandado
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadanoDemandado()
    {
        return $this->ciudadanoDemandado;
    }

    /**
     * Set ciudadanoDemandante
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadanoDemandante
     *
     * @return LimitacionDatos
     */
    public function setCiudadanoDemandante(\AppBundle\Entity\Ciudadano $ciudadanoDemandante = null)
    {
        $this->ciudadanoDemandante = $ciudadanoDemandante;

        return $this;
    }

    /**
     * Get ciudadanoDemandante
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadanoDemandante()
    {
        return $this->ciudadanoDemandante;
    }

    /**
     * Set limitacion
     *
     * @param \AppBundle\Entity\CfgLimitacion $limitacion
     *
     * @return LimitacionDatos
     */
    public function setLimitacion(\AppBundle\Entity\CfgLimitacion $limitacion = null)
    {
        $this->limitacion = $limitacion;

        return $this;
    }

    /**
     * Get limitacion
     *
     * @return \AppBundle\Entity\CfgLimitacion
     */
    public function getLimitacion()
    {
        return $this->limitacion;
    }

    /**
     * Set tipoProceso
     *
     * @param \AppBundle\Entity\CfgTipoProceso $tipoProceso
     *
     * @return LimitacionDatos
     */
    public function setTipoProceso(\AppBundle\Entity\CfgTipoProceso $tipoProceso = null)
    {
        $this->tipoProceso = $tipoProceso;

        return $this;
    }

    /**
     * Get tipoProceso
     *
     * @return \AppBundle\Entity\CfgTipoProceso
     */
    public function getTipoProceso()
    {
        return $this->tipoProceso;
    }

    /**
     * Set entidadJudicial
     *
     * @param \AppBundle\Entity\CfgEntidadJudicial $entidadJudicial
     *
     * @return LimitacionDatos
     */
    public function setEntidadJudicial(\AppBundle\Entity\CfgEntidadJudicial $entidadJudicial = null)
    {
        $this->entidadJudicial = $entidadJudicial;

        return $this;
    }

    /**
     * Get entidadJudicial
     *
     * @return \AppBundle\Entity\CfgEntidadJudicial
     */
    public function getEntidadJudicial()
    {
        return $this->entidadJudicial;
    }
}
