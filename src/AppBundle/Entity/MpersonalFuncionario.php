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
     * @ORM\Column(name="objetoContrato", type="text", nullable=true)
     */
    private $objetoContrato;

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
     * @var bool
     *
     * @ORM\Column(name="modificatorio", type="boolean")
     */
    private $modificatorio;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="funcionarios")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalCfgCargo", inversedBy="funcionarios")
     **/
    protected $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="funcionarios")
     **/
    protected $ciudadano;


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
     * Set objetoContrato
     *
     * @param string $objetoContrato
     *
     * @return MpersonalFuncionario
     */
    public function setObjetoContrato($objetoContrato)
    {
        $this->objetoContrato = $objetoContrato;

        return $this;
    }

    /**
     * Get objetoContrato
     *
     * @return string
     */
    public function getObjetoContrato()
    {
        return $this->objetoContrato;
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
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set modificatorio
     *
     * @param boolean $modificatorio
     *
     * @return MpersonalFuncionario
     */
    public function setModificatorio($modificatorio)
    {
        $this->modificatorio = $modificatorio;

        return $this;
    }

    /**
     * Get modificatorio
     *
     * @return boolean
     */
    public function getModificatorio()
    {
        return $this->modificatorio;
    }

    /**
     * Set sedeOperativa
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $sedeOperativa
     *
     * @return MpersonalFuncionario
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
     * Set cargo
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgCargo $cargo
     *
     * @return MpersonalFuncionario
     */
    public function setCargo(\JHWEB\PersonalBundle\Entity\PnalCfgCargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalCfgCargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return MpersonalFuncionario
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }
}
