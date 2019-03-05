<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvEvaluacion
 *
 * @ORM\Table(name="msv_evaluacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvEvaluacionRepository")
 */
class MsvEvaluacion
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
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa", inversedBy="resultados")
     **/
    protected $empresa;
   
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MsvRevision")
     */
    private $revision;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable = true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="pilar_fortalecimiento", type="string", length=255, nullable = true)
     */
    private $pilarFortalecimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_fortalecimiento", type="float", nullable = true)
     */
    private $valorObtenidoFortalecimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_fortalecimiento", type="float", nullable = true)
     */
    private $valorPonderadoFortalecimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_fortalecimiento", type="float", nullable = true)
     */
    private $resultadoFortalecimiento;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_comportamiento", type="string", length=255, nullable = true)
     */
    private $pilarComportamiento;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_comportamiento", type="float", nullable = true)
     */
    private $valorObtenidoComportamiento;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_comportamiento", type="float", nullable = true)
     */
    private $valorPonderadoComportamiento;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_comportamiento", type="float", nullable = true)
     */
    private $resultadoComportamiento;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_vehiculo_seguro", type="string", length=255, nullable = true)
     */
    private $pilarVehiculoSeguro;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_vehiculo_seguro", type="float", nullable = true)
     */
    private $valorObtenidoVehiculoSeguro;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_vehiculo_seguro", type="float", nullable = true)
     */
    private $valorPonderadoVehiculoSeguro;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_vehiculo_seguro", type="float", nullable = true)
     */
    private $resultadoVehiculoSeguro;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_infraestructura_segura", type="string", length=255, nullable = true)
     */
    private $pilarInfraestructuraSegura;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_infraestructura_segura", type="float", nullable = true)
     */
    private $valorObtenidoInfraestructuraSegura;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_infraestructura_segura", type="float", nullable = true)
     */
    private $valorPonderadoInfraestructuraSegura;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_infraestructura_segura", type="float", nullable = true)
     */
    private $resultadoInfraestructuraSegura;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_atencion_victima", type="string", length=255, nullable = true)
     */
    private $pilarAtencionVictima;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_atencion_victima", type="float", nullable = true)
     */
    private $valorObtenidoAtencionVictima;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_atencion_victima", type="float", nullable = true)
     */
    private $valorPonderadoAtencionVictima;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_atencion_victima", type="float", nullable = true)
     */
    private $resultadoAtencionVictima;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_valor_agregado", type="string", length=255, nullable = true)
     */
    private $pilarValorAgregado;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_obtenido_valor_agregado", type="float", nullable = true)
     */
    private $valorObtenidoValorAgregado;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_ponderado_valor_agregado", type="float", nullable = true)
     */
    private $valorPonderadoValorAgregado;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_valor_agregado", type="float", nullable = true)
     */
    private $resultadoValorAgregado;

    /**
     * @var float
     *
     * @ORM\Column(name="resultado_final", type="float", nullable = true)
     */
    private $resultadofinal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aval", type="boolean")
     */
    private $aval;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MsvEvaluacion
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
     * Set pilarFortalecimiento
     *
     * @param string $pilarFortalecimiento
     *
     * @return MsvEvaluacion
     */
    public function setPilarFortalecimiento($pilarFortalecimiento)
    {
        $this->pilarFortalecimiento = $pilarFortalecimiento;

        return $this;
    }

    /**
     * Get pilarFortalecimiento
     *
     * @return string
     */
    public function getPilarFortalecimiento()
    {
        return $this->pilarFortalecimiento;
    }

    /**
     * Set valorObtenidoFortalecimiento
     *
     * @param float $valorObtenidoFortalecimiento
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoFortalecimiento($valorObtenidoFortalecimiento)
    {
        $this->valorObtenidoFortalecimiento = $valorObtenidoFortalecimiento;

        return $this;
    }

    /**
     * Get valorObtenidoFortalecimiento
     *
     * @return float
     */
    public function getValorObtenidoFortalecimiento()
    {
        return $this->valorObtenidoFortalecimiento;
    }

    /**
     * Set valorPonderadoFortalecimiento
     *
     * @param float $valorPonderadoFortalecimiento
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoFortalecimiento($valorPonderadoFortalecimiento)
    {
        $this->valorPonderadoFortalecimiento = $valorPonderadoFortalecimiento;

        return $this;
    }

    /**
     * Get valorPonderadoFortalecimiento
     *
     * @return float
     */
    public function getValorPonderadoFortalecimiento()
    {
        return $this->valorPonderadoFortalecimiento;
    }

    /**
     * Set resultadoFortalecimiento
     *
     * @param float $resultadoFortalecimiento
     *
     * @return MsvEvaluacion
     */
    public function setResultadoFortalecimiento($resultadoFortalecimiento)
    {
        $this->resultadoFortalecimiento = $resultadoFortalecimiento;

        return $this;
    }

    /**
     * Get resultadoFortalecimiento
     *
     * @return float
     */
    public function getResultadoFortalecimiento()
    {
        return $this->resultadoFortalecimiento;
    }

    /**
     * Set pilarComportamiento
     *
     * @param string $pilarComportamiento
     *
     * @return MsvEvaluacion
     */
    public function setPilarComportamiento($pilarComportamiento)
    {
        $this->pilarComportamiento = $pilarComportamiento;

        return $this;
    }

    /**
     * Get pilarComportamiento
     *
     * @return string
     */
    public function getPilarComportamiento()
    {
        return $this->pilarComportamiento;
    }

    /**
     * Set valorObtenidoComportamiento
     *
     * @param float $valorObtenidoComportamiento
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoComportamiento($valorObtenidoComportamiento)
    {
        $this->valorObtenidoComportamiento = $valorObtenidoComportamiento;

        return $this;
    }

    /**
     * Get valorObtenidoComportamiento
     *
     * @return float
     */
    public function getValorObtenidoComportamiento()
    {
        return $this->valorObtenidoComportamiento;
    }

    /**
     * Set valorPonderadoComportamiento
     *
     * @param float $valorPonderadoComportamiento
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoComportamiento($valorPonderadoComportamiento)
    {
        $this->valorPonderadoComportamiento = $valorPonderadoComportamiento;

        return $this;
    }

    /**
     * Get valorPonderadoComportamiento
     *
     * @return float
     */
    public function getValorPonderadoComportamiento()
    {
        return $this->valorPonderadoComportamiento;
    }

    /**
     * Set resultadoComportamiento
     *
     * @param float $resultadoComportamiento
     *
     * @return MsvEvaluacion
     */
    public function setResultadoComportamiento($resultadoComportamiento)
    {
        $this->resultadoComportamiento = $resultadoComportamiento;

        return $this;
    }

    /**
     * Get resultadoComportamiento
     *
     * @return float
     */
    public function getResultadoComportamiento()
    {
        return $this->resultadoComportamiento;
    }

    /**
     * Set pilarVehiculoSeguro
     *
     * @param string $pilarVehiculoSeguro
     *
     * @return MsvEvaluacion
     */
    public function setPilarVehiculoSeguro($pilarVehiculoSeguro)
    {
        $this->pilarVehiculoSeguro = $pilarVehiculoSeguro;

        return $this;
    }

    /**
     * Get pilarVehiculoSeguro
     *
     * @return string
     */
    public function getPilarVehiculoSeguro()
    {
        return $this->pilarVehiculoSeguro;
    }

    /**
     * Set valorObtenidoVehiculoSeguro
     *
     * @param float $valorObtenidoVehiculoSeguro
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoVehiculoSeguro($valorObtenidoVehiculoSeguro)
    {
        $this->valorObtenidoVehiculoSeguro = $valorObtenidoVehiculoSeguro;

        return $this;
    }

    /**
     * Get valorObtenidoVehiculoSeguro
     *
     * @return float
     */
    public function getValorObtenidoVehiculoSeguro()
    {
        return $this->valorObtenidoVehiculoSeguro;
    }

    /**
     * Set valorPonderadoVehiculoSeguro
     *
     * @param float $valorPonderadoVehiculoSeguro
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoVehiculoSeguro($valorPonderadoVehiculoSeguro)
    {
        $this->valorPonderadoVehiculoSeguro = $valorPonderadoVehiculoSeguro;

        return $this;
    }

    /**
     * Get valorPonderadoVehiculoSeguro
     *
     * @return float
     */
    public function getValorPonderadoVehiculoSeguro()
    {
        return $this->valorPonderadoVehiculoSeguro;
    }

    /**
     * Set resultadoVehiculoSeguro
     *
     * @param float $resultadoVehiculoSeguro
     *
     * @return MsvEvaluacion
     */
    public function setResultadoVehiculoSeguro($resultadoVehiculoSeguro)
    {
        $this->resultadoVehiculoSeguro = $resultadoVehiculoSeguro;

        return $this;
    }

    /**
     * Get resultadoVehiculoSeguro
     *
     * @return float
     */
    public function getResultadoVehiculoSeguro()
    {
        return $this->resultadoVehiculoSeguro;
    }

    /**
     * Set pilarInfraestructuraSegura
     *
     * @param string $pilarInfraestructuraSegura
     *
     * @return MsvEvaluacion
     */
    public function setPilarInfraestructuraSegura($pilarInfraestructuraSegura)
    {
        $this->pilarInfraestructuraSegura = $pilarInfraestructuraSegura;

        return $this;
    }

    /**
     * Get pilarInfraestructuraSegura
     *
     * @return string
     */
    public function getPilarInfraestructuraSegura()
    {
        return $this->pilarInfraestructuraSegura;
    }

    /**
     * Set valorObtenidoInfraestructuraSegura
     *
     * @param float $valorObtenidoInfraestructuraSegura
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoInfraestructuraSegura($valorObtenidoInfraestructuraSegura)
    {
        $this->valorObtenidoInfraestructuraSegura = $valorObtenidoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get valorObtenidoInfraestructuraSegura
     *
     * @return float
     */
    public function getValorObtenidoInfraestructuraSegura()
    {
        return $this->valorObtenidoInfraestructuraSegura;
    }

    /**
     * Set valorPonderadoInfraestructuraSegura
     *
     * @param float $valorPonderadoInfraestructuraSegura
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoInfraestructuraSegura($valorPonderadoInfraestructuraSegura)
    {
        $this->valorPonderadoInfraestructuraSegura = $valorPonderadoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get valorPonderadoInfraestructuraSegura
     *
     * @return float
     */
    public function getValorPonderadoInfraestructuraSegura()
    {
        return $this->valorPonderadoInfraestructuraSegura;
    }

    /**
     * Set resultadoInfraestructuraSegura
     *
     * @param float $resultadoInfraestructuraSegura
     *
     * @return MsvEvaluacion
     */
    public function setResultadoInfraestructuraSegura($resultadoInfraestructuraSegura)
    {
        $this->resultadoInfraestructuraSegura = $resultadoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get resultadoInfraestructuraSegura
     *
     * @return float
     */
    public function getResultadoInfraestructuraSegura()
    {
        return $this->resultadoInfraestructuraSegura;
    }

    /**
     * Set pilarAtencionVictima
     *
     * @param string $pilarAtencionVictima
     *
     * @return MsvEvaluacion
     */
    public function setPilarAtencionVictima($pilarAtencionVictima)
    {
        $this->pilarAtencionVictima = $pilarAtencionVictima;

        return $this;
    }

    /**
     * Get pilarAtencionVictima
     *
     * @return string
     */
    public function getPilarAtencionVictima()
    {
        return $this->pilarAtencionVictima;
    }

    /**
     * Set valorObtenidoAtencionVictima
     *
     * @param float $valorObtenidoAtencionVictima
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoAtencionVictima($valorObtenidoAtencionVictima)
    {
        $this->valorObtenidoAtencionVictima = $valorObtenidoAtencionVictima;

        return $this;
    }

    /**
     * Get valorObtenidoAtencionVictima
     *
     * @return float
     */
    public function getValorObtenidoAtencionVictima()
    {
        return $this->valorObtenidoAtencionVictima;
    }

    /**
     * Set valorPonderadoAtencionVictima
     *
     * @param float $valorPonderadoAtencionVictima
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoAtencionVictima($valorPonderadoAtencionVictima)
    {
        $this->valorPonderadoAtencionVictima = $valorPonderadoAtencionVictima;

        return $this;
    }

    /**
     * Get valorPonderadoAtencionVictima
     *
     * @return float
     */
    public function getValorPonderadoAtencionVictima()
    {
        return $this->valorPonderadoAtencionVictima;
    }

    /**
     * Set resultadoAtencionVictima
     *
     * @param float $resultadoAtencionVictima
     *
     * @return MsvEvaluacion
     */
    public function setResultadoAtencionVictima($resultadoAtencionVictima)
    {
        $this->resultadoAtencionVictima = $resultadoAtencionVictima;

        return $this;
    }

    /**
     * Get resultadoAtencionVictima
     *
     * @return float
     */
    public function getResultadoAtencionVictima()
    {
        return $this->resultadoAtencionVictima;
    }

    /**
     * Set pilarValorAgregado
     *
     * @param string $pilarValorAgregado
     *
     * @return MsvEvaluacion
     */
    public function setPilarValorAgregado($pilarValorAgregado)
    {
        $this->pilarValorAgregado = $pilarValorAgregado;

        return $this;
    }

    /**
     * Get pilarValorAgregado
     *
     * @return string
     */
    public function getPilarValorAgregado()
    {
        return $this->pilarValorAgregado;
    }

    /**
     * Set valorObtenidoValorAgregado
     *
     * @param float $valorObtenidoValorAgregado
     *
     * @return MsvEvaluacion
     */
    public function setValorObtenidoValorAgregado($valorObtenidoValorAgregado)
    {
        $this->valorObtenidoValorAgregado = $valorObtenidoValorAgregado;

        return $this;
    }

    /**
     * Get valorObtenidoValorAgregado
     *
     * @return float
     */
    public function getValorObtenidoValorAgregado()
    {
        return $this->valorObtenidoValorAgregado;
    }

    /**
     * Set valorPonderadoValorAgregado
     *
     * @param float $valorPonderadoValorAgregado
     *
     * @return MsvEvaluacion
     */
    public function setValorPonderadoValorAgregado($valorPonderadoValorAgregado)
    {
        $this->valorPonderadoValorAgregado = $valorPonderadoValorAgregado;

        return $this;
    }

    /**
     * Get valorPonderadoValorAgregado
     *
     * @return float
     */
    public function getValorPonderadoValorAgregado()
    {
        return $this->valorPonderadoValorAgregado;
    }

    /**
     * Set resultadoValorAgregado
     *
     * @param float $resultadoValorAgregado
     *
     * @return MsvEvaluacion
     */
    public function setResultadoValorAgregado($resultadoValorAgregado)
    {
        $this->resultadoValorAgregado = $resultadoValorAgregado;

        return $this;
    }

    /**
     * Get resultadoValorAgregado
     *
     * @return float
     */
    public function getResultadoValorAgregado()
    {
        return $this->resultadoValorAgregado;
    }

    /**
     * Set resultadofinal
     *
     * @param float $resultadofinal
     *
     * @return MsvEvaluacion
     */
    public function setResultadofinal($resultadofinal)
    {
        $this->resultadofinal = $resultadofinal;

        return $this;
    }

    /**
     * Get resultadofinal
     *
     * @return float
     */
    public function getResultadofinal()
    {
        return $this->resultadofinal;
    }

    /**
     * Set aval
     *
     * @param boolean $aval
     *
     * @return MsvEvaluacion
     */
    public function setAval($aval)
    {
        $this->aval = $aval;

        return $this;
    }

    /**
     * Get aval
     *
     * @return boolean
     */
    public function getAval()
    {
        return $this->aval;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MsvEvaluacion
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
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return MsvEvaluacion
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
     * Set revision
     *
     * @param \AppBundle\Entity\MsvRevision $revision
     *
     * @return MsvEvaluacion
     */
    public function setRevision(\AppBundle\Entity\MsvRevision $revision = null)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return \AppBundle\Entity\MsvRevision
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
