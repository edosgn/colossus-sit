<?php

namespace JHWEB\ParqueaderoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PqoInmovilizacion
 *
 * @ORM\Table(name="pqo_inmovilizacion")
 * @ORM\Entity(repositoryClass="JHWEB\ParqueaderoBundle\Repository\PqoInmovilizacionRepository")
 */
class PqoInmovilizacion
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
     * @ORM\Column(name="numero_comparendo", type="bigint")
     */
    private $numeroComparendo;

    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=255, nullable=true)
     */
    private $placa;

    /**
     * @var string
     *
     * @ORM\Column(name="motor", type="string", length=255, nullable=true)
     */
    private $motor;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis", type="string", length=255, nullable=true)
     */
    private $chasis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="date")
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_ingreso", type="time")
     */
    private $horaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inmovilizacion", type="date")
     */
    private $fechaInmovilizacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_inmovilizacion", type="time")
     */
    private $horaInmovilizacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salida", type="date", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_salida", type="time", nullable=true)
     */
    private $horaSalida;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_salida", type="integer", nullable=true)
     */
    private $numeroSalida;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_inventario", type="integer")
     */
    private $numeroInventario;

    /**
     * @var int
     *
     * @ORM\Column(name="dias", type="integer", nullable=true)
     */
    private $dias;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer", nullable=true)
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="costo_grua", type="integer", nullable=true)
     */
    private $costoGrua;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="salida", type="boolean")
     */
    private $salida = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgLinea", inversedBy="inmovilizaciones") */
    private $linea;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgColor", inversedBy="inmovilizaciones") */
    private $color;

    /** @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloCfgClase", inversedBy="inmovilizaciones") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="PqoCfgGrua", inversedBy="inmovilizaciones") */
    private $grua;

    /** @ORM\ManyToOne(targetEntity="PqoCfgPatio", inversedBy="inmovilizaciones") */
    private $patio;


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
     * Set numeroComparendo
     *
     * @param integer $numeroComparendo
     *
     * @return PqoInmovilizacion
     */
    public function setNumeroComparendo($numeroComparendo)
    {
        $this->numeroComparendo = $numeroComparendo;

        return $this;
    }

    /**
     * Get numeroComparendo
     *
     * @return integer
     */
    public function getNumeroComparendo()
    {
        return $this->numeroComparendo;
    }

    /**
     * Set placa
     *
     * @param string $placa
     *
     * @return PqoInmovilizacion
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set motor
     *
     * @param string $motor
     *
     * @return PqoInmovilizacion
     */
    public function setMotor($motor)
    {
        $this->motor = $motor;

        return $this;
    }

    /**
     * Get motor
     *
     * @return string
     */
    public function getMotor()
    {
        return $this->motor;
    }

    /**
     * Set chasis
     *
     * @param string $chasis
     *
     * @return PqoInmovilizacion
     */
    public function setChasis($chasis)
    {
        $this->chasis = $chasis;

        return $this;
    }

    /**
     * Get chasis
     *
     * @return string
     */
    public function getChasis()
    {
        return $this->chasis;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return PqoInmovilizacion
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set horaIngreso
     *
     * @param \DateTime $horaIngreso
     *
     * @return PqoInmovilizacion
     */
    public function setHoraIngreso($horaIngreso)
    {
        $this->horaIngreso = $horaIngreso;

        return $this;
    }

    /**
     * Get horaIngreso
     *
     * @return \DateTime
     */
    public function getHoraIngreso()
    {
        return $this->horaIngreso;
    }

    /**
     * Set fechaInmovilizacion
     *
     * @param \DateTime $fechaInmovilizacion
     *
     * @return PqoInmovilizacion
     */
    public function setFechaInmovilizacion($fechaInmovilizacion)
    {
        $this->fechaInmovilizacion = $fechaInmovilizacion;

        return $this;
    }

    /**
     * Get fechaInmovilizacion
     *
     * @return \DateTime
     */
    public function getFechaInmovilizacion()
    {
        return $this->fechaInmovilizacion;
    }

    /**
     * Set horaInmovilizacion
     *
     * @param \DateTime $horaInmovilizacion
     *
     * @return PqoInmovilizacion
     */
    public function setHoraInmovilizacion($horaInmovilizacion)
    {
        $this->horaInmovilizacion = $horaInmovilizacion;

        return $this;
    }

    /**
     * Get horaInmovilizacion
     *
     * @return \DateTime
     */
    public function getHoraInmovilizacion()
    {
        return $this->horaInmovilizacion;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return PqoInmovilizacion
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set horaSalida
     *
     * @param \DateTime $horaSalida
     *
     * @return PqoInmovilizacion
     */
    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;

        return $this;
    }

    /**
     * Get horaSalida
     *
     * @return \DateTime
     */
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    /**
     * Set numeroSalida
     *
     * @param integer $numeroSalida
     *
     * @return PqoInmovilizacion
     */
    public function setNumeroSalida($numeroSalida)
    {
        $this->numeroSalida = $numeroSalida;

        return $this;
    }

    /**
     * Get numeroSalida
     *
     * @return integer
     */
    public function getNumeroSalida()
    {
        return $this->numeroSalida;
    }

    /**
     * Set numeroInventario
     *
     * @param integer $numeroInventario
     *
     * @return PqoInmovilizacion
     */
    public function setNumeroInventario($numeroInventario)
    {
        $this->numeroInventario = $numeroInventario;

        return $this;
    }

    /**
     * Get numeroInventario
     *
     * @return integer
     */
    public function getNumeroInventario()
    {
        return $this->numeroInventario;
    }

    /**
     * Set dias
     *
     * @param integer $dias
     *
     * @return PqoInmovilizacion
     */
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    /**
     * Get dias
     *
     * @return integer
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return PqoInmovilizacion
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return PqoInmovilizacion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set costoGrua
     *
     * @param integer $costoGrua
     *
     * @return PqoInmovilizacion
     */
    public function setCostoGrua($costoGrua)
    {
        $this->costoGrua = $costoGrua;

        return $this;
    }

    /**
     * Get costoGrua
     *
     * @return integer
     */
    public function getCostoGrua()
    {
        return $this->costoGrua;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return PqoInmovilizacion
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
     * Set salida
     *
     * @param boolean $salida
     *
     * @return PqoInmovilizacion
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return boolean
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PqoInmovilizacion
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
     * Set linea
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea
     *
     * @return PqoInmovilizacion
     */
    public function setLinea(\JHWEB\VehiculoBundle\Entity\VhloCfgLinea $linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgLinea
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set color
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgColor $color
     *
     * @return PqoInmovilizacion
     */
    public function setColor(\JHWEB\VehiculoBundle\Entity\VhloCfgColor $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set clase
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase
     *
     * @return PqoInmovilizacion
     */
    public function setClase(\JHWEB\VehiculoBundle\Entity\VhloCfgClase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloCfgClase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set grua
     *
     * @param \JHWEB\ParqueaderoBundle\Entity\PqoCfgGrua $grua
     *
     * @return PqoInmovilizacion
     */
    public function setGrua(\JHWEB\ParqueaderoBundle\Entity\PqoCfgGrua $grua = null)
    {
        $this->grua = $grua;

        return $this;
    }

    /**
     * Get grua
     *
     * @return \JHWEB\ParqueaderoBundle\Entity\PqoCfgGrua
     */
    public function getGrua()
    {
        return $this->grua;
    }

    /**
     * Set patio
     *
     * @param \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio
     *
     * @return PqoInmovilizacion
     */
    public function setPatio(\JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio = null)
    {
        $this->patio = $patio;

        return $this;
    }

    /**
     * Get patio
     *
     * @return \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio
     */
    public function getPatio()
    {
        return $this->patio;
    }
}
