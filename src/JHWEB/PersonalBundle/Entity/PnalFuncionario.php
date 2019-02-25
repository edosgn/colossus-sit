<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalFuncionario
 *
 * @ORM\Table(name="pnal_funcionario")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalFuncionarioRepository")
 */
class PnalFuncionario
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
     * @ORM\Column(name="acta_posesion", type="string", length=10, nullable=true)
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
     * @ORM\Column(name="numero_contrato", type="string", length=10, nullable=true)
     */
    private $numeroContrato;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicial", type="date", nullable=true)
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_placa", type="string", length=10, nullable=true)
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
     * @ORM\Column(name="objeto_contrato", type="text", nullable=true)
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
     * @ORM\Column(name="modificatorio", type="boolean")
     */
    private $modificatorio;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="PnalCfgTipoNombramiento", inversedBy="funcionarios")
     **/
    protected $tipoNombramiento;

    /**
     * @ORM\ManyToOne(targetEntity="PnalCfgTipoContrato", inversedBy="funcionarios")
     **/
    protected $tipoContrato;

    /**
     * @ORM\ManyToOne(targetEntity="PnalCfgCargo", inversedBy="funcionarios")
     **/
    protected $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="funcionarios")
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
     * Set actaPosesion
     *
     * @param string $actaPosesion
     *
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     *
     * @return PnalFuncionario
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return PnalFuncionario
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set numeroPlaca
     *
     * @param string $numeroPlaca
     *
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
     * Set modificatorio
     *
     * @param boolean $modificatorio
     *
     * @return PnalFuncionario
     */
    public function setModificatorio($modificatorio)
    {
        $this->modificatorio = $modificatorio;

        return $this;
    }

    /**
     * Get modificatorio
     *
     * @return bool
     */
    public function getModificatorio()
    {
        return $this->modificatorio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalFuncionario
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
     * Set tipoNombramiento
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgTipoNombramiento $tipoNombramiento
     *
     * @return PnalFuncionario
     */
    public function setTipoNombramiento(\JHWEB\PersonalBundle\Entity\PnalCfgTipoNombramiento $tipoNombramiento = null)
    {
        $this->tipoNombramiento = $tipoNombramiento;

        return $this;
    }

    /**
     * Get tipoNombramiento
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalCfgTipoNombramiento
     */
    public function getTipoNombramiento()
    {
        return $this->tipoNombramiento;
    }

    /**
     * Set tipoContrato
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgTipoContrato $tipoContrato
     *
     * @return PnalFuncionario
     */
    public function setTipoContrato(\JHWEB\PersonalBundle\Entity\PnalCfgTipoContrato $tipoContrato = null)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalCfgTipoContrato
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    /**
     * Set cargo
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalCfgCargo $cargo
     *
     * @return PnalFuncionario
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
     * @return PnalFuncionario
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
