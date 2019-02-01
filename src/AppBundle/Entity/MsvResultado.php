<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvResultado
 *
 * @ORM\Table(name="msv_resultado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvResultadoRepository")
 */
class MsvResultado
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
     * @ORM\Column(name="pilar_fortalecimiento", type="string", length=255)
     */
    private $pilarFortalecimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_fortalecimiento", type="integer", length=255)
     */
    private $valorObtenidoFortalecimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_fortalecimiento", type="integer", length=255)
     */
    private $valorPonderadoFortalecimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_fortalecimiento", type="integer", length=255)
     */
    private $resultadoFortalecimiento;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_comportamiento", type="string", length=255)
     */
    private $pilarComportamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_comportamiento", type="integer", length=255)
     */
    private $valorObtenidoComportamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_comportamiento", type="integer", length=255)
     */
    private $valorPonderadoComportamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_comportamiento", type="integer", length=255)
     */
    private $resultadoComportamiento;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_vehiculo_seguro", type="string", length=255)
     */
    private $pilarVehiculoSeguro;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_vehiculo_seguro", type="integer", length=255)
     */
    private $valorObtenidoVehiculoSeguro;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_vehiculo_seguro", type="integer", length=255)
     */
    private $valorPonderadoVehiculoSeguro;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_vehiculo_seguro", type="integer", length=255)
     */
    private $resultadoVehiculoSeguro;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_infraestructura_segura", type="string", length=255)
     */
    private $pilarInfraestructuraSegura;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_infraestructura_segura", type="integer", length=255)
     */
    private $valorObtenidoInfraestructuraSegura;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_infraestructura_segura", type="integer", length=255)
     */
    private $valorPonderadoInfraestructuraSegura;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_infraestructura_segura", type="integer", length=255)
     */
    private $resultadoInfraestructuraSegura;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_atencion_victima", type="string", length=255)
     */
    private $pilarAtencionVictima;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_atencion_victima", type="integer", length=255)
     */
    private $valorObtenidoAtencionVictima;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_atencion_victima", type="integer", length=255)
     */
    private $valorPonderadoAtencionVictima;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_atencion_victima", type="integer", length=255)
     */
    private $resultadoAtencionVictima;


    /**
     * @var string
     *
     * @ORM\Column(name="pilar_valor_agregado", type="string", length=255)
     */
    private $pilarValorAgregado;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido_valor_agregado", type="integer", length=255)
     */
    private $valorObtenidoValorAgregado;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado_valor_agregado", type="integer", length=255)
     */
    private $valorPonderadoValorAgregado;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_valor_agregado", type="integer", length=255)
     */
    private $resultadoValorAgregado;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado_final", type="integer", length=255)
     */
    private $resultadofinal;


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
     * Set pilarFortalecimiento
     *
     * @param string $pilarFortalecimiento
     *
     * @return MsvResultado
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
     * @param integer $valorObtenidoFortalecimiento
     *
     * @return MsvResultado
     */
    public function setValorObtenidoFortalecimiento($valorObtenidoFortalecimiento)
    {
        $this->valorObtenidoFortalecimiento = $valorObtenidoFortalecimiento;

        return $this;
    }

    /**
     * Get valorObtenidoFortalecimiento
     *
     * @return integer
     */
    public function getValorObtenidoFortalecimiento()
    {
        return $this->valorObtenidoFortalecimiento;
    }

    /**
     * Set valorPonderadoFortalecimiento
     *
     * @param integer $valorPonderadoFortalecimiento
     *
     * @return MsvResultado
     */
    public function setValorPonderadoFortalecimiento($valorPonderadoFortalecimiento)
    {
        $this->valorPonderadoFortalecimiento = $valorPonderadoFortalecimiento;

        return $this;
    }

    /**
     * Get valorPonderadoFortalecimiento
     *
     * @return integer
     */
    public function getValorPonderadoFortalecimiento()
    {
        return $this->valorPonderadoFortalecimiento;
    }

    /**
     * Set resultadoFortalecimiento
     *
     * @param integer $resultadoFortalecimiento
     *
     * @return MsvResultado
     */
    public function setResultadoFortalecimiento($resultadoFortalecimiento)
    {
        $this->resultadoFortalecimiento = $resultadoFortalecimiento;

        return $this;
    }

    /**
     * Get resultadoFortalecimiento
     *
     * @return integer
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
     * @return MsvResultado
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
     * @param integer $valorObtenidoComportamiento
     *
     * @return MsvResultado
     */
    public function setValorObtenidoComportamiento($valorObtenidoComportamiento)
    {
        $this->valorObtenidoComportamiento = $valorObtenidoComportamiento;

        return $this;
    }

    /**
     * Get valorObtenidoComportamiento
     *
     * @return integer
     */
    public function getValorObtenidoComportamiento()
    {
        return $this->valorObtenidoComportamiento;
    }

    /**
     * Set valorPonderadoComportamiento
     *
     * @param integer $valorPonderadoComportamiento
     *
     * @return MsvResultado
     */
    public function setValorPonderadoComportamiento($valorPonderadoComportamiento)
    {
        $this->valorPonderadoComportamiento = $valorPonderadoComportamiento;

        return $this;
    }

    /**
     * Get valorPonderadoComportamiento
     *
     * @return integer
     */
    public function getValorPonderadoComportamiento()
    {
        return $this->valorPonderadoComportamiento;
    }

    /**
     * Set resultadoComportamiento
     *
     * @param integer $resultadoComportamiento
     *
     * @return MsvResultado
     */
    public function setResultadoComportamiento($resultadoComportamiento)
    {
        $this->resultadoComportamiento = $resultadoComportamiento;

        return $this;
    }

    /**
     * Get resultadoComportamiento
     *
     * @return integer
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
     * @return MsvResultado
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
     * @param integer $valorObtenidoVehiculoSeguro
     *
     * @return MsvResultado
     */
    public function setValorObtenidoVehiculoSeguro($valorObtenidoVehiculoSeguro)
    {
        $this->valorObtenidoVehiculoSeguro = $valorObtenidoVehiculoSeguro;

        return $this;
    }

    /**
     * Get valorObtenidoVehiculoSeguro
     *
     * @return integer
     */
    public function getValorObtenidoVehiculoSeguro()
    {
        return $this->valorObtenidoVehiculoSeguro;
    }

    /**
     * Set valorPonderadoVehiculoSeguro
     *
     * @param integer $valorPonderadoVehiculoSeguro
     *
     * @return MsvResultado
     */
    public function setValorPonderadoVehiculoSeguro($valorPonderadoVehiculoSeguro)
    {
        $this->valorPonderadoVehiculoSeguro = $valorPonderadoVehiculoSeguro;

        return $this;
    }

    /**
     * Get valorPonderadoVehiculoSeguro
     *
     * @return integer
     */
    public function getValorPonderadoVehiculoSeguro()
    {
        return $this->valorPonderadoVehiculoSeguro;
    }

    /**
     * Set resultadoVehiculoSeguro
     *
     * @param integer $resultadoVehiculoSeguro
     *
     * @return MsvResultado
     */
    public function setResultadoVehiculoSeguro($resultadoVehiculoSeguro)
    {
        $this->resultadoVehiculoSeguro = $resultadoVehiculoSeguro;

        return $this;
    }

    /**
     * Get resultadoVehiculoSeguro
     *
     * @return integer
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
     * @return MsvResultado
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
     * @param integer $valorObtenidoInfraestructuraSegura
     *
     * @return MsvResultado
     */
    public function setValorObtenidoInfraestructuraSegura($valorObtenidoInfraestructuraSegura)
    {
        $this->valorObtenidoInfraestructuraSegura = $valorObtenidoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get valorObtenidoInfraestructuraSegura
     *
     * @return integer
     */
    public function getValorObtenidoInfraestructuraSegura()
    {
        return $this->valorObtenidoInfraestructuraSegura;
    }

    /**
     * Set valorPonderadoInfraestructuraSegura
     *
     * @param integer $valorPonderadoInfraestructuraSegura
     *
     * @return MsvResultado
     */
    public function setValorPonderadoInfraestructuraSegura($valorPonderadoInfraestructuraSegura)
    {
        $this->valorPonderadoInfraestructuraSegura = $valorPonderadoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get valorPonderadoInfraestructuraSegura
     *
     * @return integer
     */
    public function getValorPonderadoInfraestructuraSegura()
    {
        return $this->valorPonderadoInfraestructuraSegura;
    }

    /**
     * Set resultadoInfraestructuraSegura
     *
     * @param integer $resultadoInfraestructuraSegura
     *
     * @return MsvResultado
     */
    public function setResultadoInfraestructuraSegura($resultadoInfraestructuraSegura)
    {
        $this->resultadoInfraestructuraSegura = $resultadoInfraestructuraSegura;

        return $this;
    }

    /**
     * Get resultadoInfraestructuraSegura
     *
     * @return integer
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
     * @return MsvResultado
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
     * @param integer $valorObtenidoAtencionVictima
     *
     * @return MsvResultado
     */
    public function setValorObtenidoAtencionVictima($valorObtenidoAtencionVictima)
    {
        $this->valorObtenidoAtencionVictima = $valorObtenidoAtencionVictima;

        return $this;
    }

    /**
     * Get valorObtenidoAtencionVictima
     *
     * @return integer
     */
    public function getValorObtenidoAtencionVictima()
    {
        return $this->valorObtenidoAtencionVictima;
    }

    /**
     * Set valorPonderadoAtencionVictima
     *
     * @param integer $valorPonderadoAtencionVictima
     *
     * @return MsvResultado
     */
    public function setValorPonderadoAtencionVictima($valorPonderadoAtencionVictima)
    {
        $this->valorPonderadoAtencionVictima = $valorPonderadoAtencionVictima;

        return $this;
    }

    /**
     * Get valorPonderadoAtencionVictima
     *
     * @return integer
     */
    public function getValorPonderadoAtencionVictima()
    {
        return $this->valorPonderadoAtencionVictima;
    }

    /**
     * Set resultadoAtencionVictima
     *
     * @param integer $resultadoAtencionVictima
     *
     * @return MsvResultado
     */
    public function setResultadoAtencionVictima($resultadoAtencionVictima)
    {
        $this->resultadoAtencionVictima = $resultadoAtencionVictima;

        return $this;
    }

    /**
     * Get resultadoAtencionVictima
     *
     * @return integer
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
     * @return MsvResultado
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
     * @param integer $valorObtenidoValorAgregado
     *
     * @return MsvResultado
     */
    public function setValorObtenidoValorAgregado($valorObtenidoValorAgregado)
    {
        $this->valorObtenidoValorAgregado = $valorObtenidoValorAgregado;

        return $this;
    }

    /**
     * Get valorObtenidoValorAgregado
     *
     * @return integer
     */
    public function getValorObtenidoValorAgregado()
    {
        return $this->valorObtenidoValorAgregado;
    }

    /**
     * Set valorPonderadoValorAgregado
     *
     * @param integer $valorPonderadoValorAgregado
     *
     * @return MsvResultado
     */
    public function setValorPonderadoValorAgregado($valorPonderadoValorAgregado)
    {
        $this->valorPonderadoValorAgregado = $valorPonderadoValorAgregado;

        return $this;
    }

    /**
     * Get valorPonderadoValorAgregado
     *
     * @return integer
     */
    public function getValorPonderadoValorAgregado()
    {
        return $this->valorPonderadoValorAgregado;
    }

    /**
     * Set resultadoValorAgregado
     *
     * @param integer $resultadoValorAgregado
     *
     * @return MsvResultado
     */
    public function setResultadoValorAgregado($resultadoValorAgregado)
    {
        $this->resultadoValorAgregado = $resultadoValorAgregado;

        return $this;
    }

    /**
     * Get resultadoValorAgregado
     *
     * @return integer
     */
    public function getResultadoValorAgregado()
    {
        return $this->resultadoValorAgregado;
    }

    /**
     * Set resultadofinal
     *
     * @param integer $resultadofinal
     *
     * @return MsvResultado
     */
    public function setResultadofinal($resultadofinal)
    {
        $this->resultadofinal = $resultadofinal;

        return $this;
    }

    /**
     * Get resultadofinal
     *
     * @return integer
     */
    public function getResultadofinal()
    {
        return $this->resultadofinal;
    }
}
