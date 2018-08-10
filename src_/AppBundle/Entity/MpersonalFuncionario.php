<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpersonalFuncionario
 *
 * @ORM\Table(name="mpersonal_funcionario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MpersonalFuncionarioRepository")
 */
class MpersonalFuncionario
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
     * @ORM\Column(name="cargo", type="string", length=255)
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="actaPosesion", type="string", length=10, nullable=true)
     */
    private $actaPosesion;

    /**
     * @var string
     *
     * @ORM\Column(name="resolucion", type="string", length=10, nullable=true)
     */
    private $resolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoNombramiento", type="string", length=50, nullable=true)
     */
    private $tipoNombramiento;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroContrato", type="string", length=10, nullable=true)
     */
    private $numeroContrato;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroPlaca", type="string", length=10, nullable=true)
     */
    private $numeroPlaca;

    /**
     * @var string
     *
     * @ORM\Column(name="inhabilidad", type="text", nullable=true)
     */
    private $inhabilidad;

    /**
     * @var string
     *
     * @ORM\Column(name="novedad", type="text", nullable=true)
     */
    private $novedad;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="funcionarios")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalTipoContrato", inversedBy="funcionarios")
     **/
    protected $tipoContrato;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="funcionarios")
     **/
    protected $ciudadano;

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
     * Set cargo
     *
     * @param string $cargo
     *
     * @return MpersonalFuncionario
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set actaPosesion
     *
     * @param string $actaPosesion
     *
     * @return MpersonalFuncionario
     */
    public function setActaPosesion($actaPosesion)
    {
        $this->actaPosesion = $actaPosesion;

        return $this;
    }

    /**
     * Get actaPosesion
     *
     * @return string
     */
    public function getActaPosesion()
    {
        return $this->actaPosesion;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return MpersonalFuncionario
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }

    /**
     * Set numeroContrato
     *
     * @param string $numeroContrato
     *
     * @return MpersonalFuncionario
     */
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;

        return $this;
    }

    /**
     * Get numeroContrato
     *
     * @return string
     */
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return MpersonalFuncionario
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return MpersonalFuncionario
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set numeroPlaca
     *
     * @param string $numeroPlaca
     *
     * @return MpersonalFuncionario
     */
    public function setNumeroPlaca($numeroPlaca)
    {
        $this->numeroPlaca = $numeroPlaca;

        return $this;
    }

    /**
     * Get numeroPlaca
     *
     * @return string
     */
    public function getNumeroPlaca()
    {
        return $this->numeroPlaca;
    }

    /**
     * Set inhabilidad
     *
     * @param string $inhabilidad
     *
     * @return MpersonalFuncionario
     */
    public function setInhabilidad($inhabilidad)
    {
        $this->inhabilidad = $inhabilidad;

        return $this;
    }

    /**
     * Get inhabilidad
     *
     * @return string
     */
    public function getInhabilidad()
    {
        return $this->inhabilidad;
    }

    /**
     * Set novedad
     *
     * @param string $novedad
     *
     * @return MpersonalFuncionario
     */
    public function setNovedad($novedad)
    {
        $this->novedad = $novedad;

        return $this;
    }

    /**
     * Get novedad
     *
     * @return string
     */
    public function getNovedad()
    {
        return $this->novedad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MpersonalFuncionario
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return MpersonalFuncionario
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
     * Set tipoContrato
     *
     * @param \AppBundle\Entity\MpersonalTipoContrato $tipoContrato
     *
     * @return MpersonalFuncionario
     */
    public function setTipoContrato(\AppBundle\Entity\MpersonalTipoContrato $tipoContrato = null)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return \AppBundle\Entity\MpersonalTipoContrato
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return MpersonalFuncionario
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set tipoNombramiento
     *
     * @param string $tipoNombramiento
     *
     * @return MpersonalFuncionario
     */
    public function setTipoNombramiento($tipoNombramiento)
    {
        $this->tipoNombramiento = $tipoNombramiento;

        return $this;
    }

    /**
     * Get tipoNombramiento
     *
     * @return string
     */
    public function getTipoNombramiento()
    {
        return $this->tipoNombramiento;
    }
}
