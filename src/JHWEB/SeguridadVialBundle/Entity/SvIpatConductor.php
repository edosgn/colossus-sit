<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatConductor
 *
 * @ORM\Table(name="sv_ipat_conductor")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatConductorRepository")
 */
class SvIpatConductor
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
     * @ORM\Column(name="nombres_conductor", type="string", nullable = true)
     */
    private $nombresConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_conductor", type="string", nullable = true)
     */
    private $apellidosConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_conductor", type="string", nullable = true)
     */
    private $tipoIdentificacionConductor;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion_conductor", type="integer", nullable = true)
     */
    private $identificacionConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad_conductor", type="string", nullable = true)
     */
    private $nacionalidadConductor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento_conductor", type="date", nullable = true)
     */
    private $fechaNacimientoConductor;

    /**
     * @var int
     *
     * @ORM\Column(name="edad_conductor", type="integer", nullable = true)
     */
    private $edadConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo_conductor", type="string", nullable = true)
     */
    private $sexoConductor;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima", inversedBy="gravedades")
     */
    private $gravedadConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_residencia_conductor", type="string", nullable = true)
     */
    private $direccionResidenciaConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad_residencia_conductor", type="string", nullable = true)
     */
    private $ciudadResidenciaConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_conductor", type="string", nullable = true)
     */
    private $telefonoConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="practico_examen_conductor", type="boolean", nullable = true)
     */
    private $practicoExamenConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="autorizo_onductor", type="boolean", nullable = true)
     */
    private $autorizoConductor;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen", inversedBy="resultadosexamen")
     */
    private $resultadoExamenConductor;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen", inversedBy="gradosexamen")
     */
    private $gradoExamenConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="sustancias_psicoactivas_conductor", type="boolean", nullable = true)
     */
    private $sustanciasPsicoactivasConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_licencia", type="boolean", nullable = true)
     */
    private $portaLicencia;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_licencia_conduccion", type="integer", nullable = true)
     */
    private $numeroLicenciaConduccion;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria_licencia_conduccion", type="string", nullable = true)
     */
    private $categoriaLicenciaConduccion;

    /**
     * @var string
     *
     * @ORM\Column(name="restriccion_conductor", type="string", nullable = true)
     */
    private $restriccionConductor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion_licencia_conduccion", type="date", nullable = true)
     */
    private $fechaExpedicionLicenciaConduccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_licencia_conduccion", type="date", nullable = true)
     */
    private $fechaVencimientoLicenciaConduccion;

    /**
     * @var string
     *
     * @ORM\Column(name="organismo_transito", type="string", nullable = true)
     */
    private $organismoTransito;

    /**
     * @var bool
     *
     * @ORM\Column(name="chaleco_conductor", type="boolean", nullable = true)
     */
    private $chalecoConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="casco_conductor", type="boolean", nullable = true)
     */
    private $cascoConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="cinturon_conductor", type="boolean", nullable = true)
     */
    private $cinturonConductor;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgHospital", inversedBy="hospitales")
     */
    private $hospitalConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_vehiculo_conductor", type="string", nullable = true)
     */
    private $placaVehiculoConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_lesion_conductor", type="string", nullable = true)
     */
    private $descripcionLesionConductor;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo", inversedBy="victimas")
     */
    private $consecutivo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set nombresConductor
     *
     * @param string $nombresConductor
     *
     * @return SvIpatConductor
     */
    public function setNombresConductor($nombresConductor)
    {
        $this->nombresConductor = $nombresConductor;

        return $this;
    }

    /**
     * Get nombresConductor
     *
     * @return string
     */
    public function getNombresConductor()
    {
        return $this->nombresConductor;
    }

    /**
     * Set apellidosConductor
     *
     * @param string $apellidosConductor
     *
     * @return SvIpatConductor
     */
    public function setApellidosConductor($apellidosConductor)
    {
        $this->apellidosConductor = $apellidosConductor;

        return $this;
    }

    /**
     * Get apellidosConductor
     *
     * @return string
     */
    public function getApellidosConductor()
    {
        return $this->apellidosConductor;
    }

    /**
     * Set tipoIdentificacionConductor
     *
     * @param string $tipoIdentificacionConductor
     *
     * @return SvIpatConductor
     */
    public function setTipoIdentificacionConductor($tipoIdentificacionConductor)
    {
        $this->tipoIdentificacionConductor = $tipoIdentificacionConductor;

        return $this;
    }

    /**
     * Get tipoIdentificacionConductor
     *
     * @return string
     */
    public function getTipoIdentificacionConductor()
    {
        return $this->tipoIdentificacionConductor;
    }

    /**
     * Set identificacionConductor
     *
     * @param integer $identificacionConductor
     *
     * @return SvIpatConductor
     */
    public function setIdentificacionConductor($identificacionConductor)
    {
        $this->identificacionConductor = $identificacionConductor;

        return $this;
    }

    /**
     * Get identificacionConductor
     *
     * @return integer
     */
    public function getIdentificacionConductor()
    {
        return $this->identificacionConductor;
    }

    /**
     * Set nacionalidadConductor
     *
     * @param string $nacionalidadConductor
     *
     * @return SvIpatConductor
     */
    public function setNacionalidadConductor($nacionalidadConductor)
    {
        $this->nacionalidadConductor = $nacionalidadConductor;

        return $this;
    }

    /**
     * Get nacionalidadConductor
     *
     * @return string
     */
    public function getNacionalidadConductor()
    {
        return $this->nacionalidadConductor;
    }

    /**
     * Set fechaNacimientoConductor
     *
     * @param \DateTime $fechaNacimientoConductor
     *
     * @return SvIpatConductor
     */
    public function setFechaNacimientoConductor($fechaNacimientoConductor)
    {
        $this->fechaNacimientoConductor = $fechaNacimientoConductor;

        return $this;
    }

    /**
     * Get fechaNacimientoConductor
     *
     * @return \DateTime
     */
    public function getFechaNacimientoConductor()
    {
        return $this->fechaNacimientoConductor;
    }

    /**
     * Set edadConductor
     *
     * @param integer $edadConductor
     *
     * @return SvIpatConductor
     */
    public function setEdadConductor($edadConductor)
    {
        $this->edadConductor = $edadConductor;

        return $this;
    }

    /**
     * Get edadConductor
     *
     * @return integer
     */
    public function getEdadConductor()
    {
        return $this->edadConductor;
    }

    /**
     * Set sexoConductor
     *
     * @param string $sexoConductor
     *
     * @return SvIpatConductor
     */
    public function setSexoConductor($sexoConductor)
    {
        $this->sexoConductor = $sexoConductor;

        return $this;
    }

    /**
     * Get sexoConductor
     *
     * @return string
     */
    public function getSexoConductor()
    {
        return $this->sexoConductor;
    }

    /**
     * Set direccionResidenciaConductor
     *
     * @param string $direccionResidenciaConductor
     *
     * @return SvIpatConductor
     */
    public function setDireccionResidenciaConductor($direccionResidenciaConductor)
    {
        $this->direccionResidenciaConductor = $direccionResidenciaConductor;

        return $this;
    }

    /**
     * Get direccionResidenciaConductor
     *
     * @return string
     */
    public function getDireccionResidenciaConductor()
    {
        return $this->direccionResidenciaConductor;
    }

    /**
     * Set ciudadResidenciaConductor
     *
     * @param string $ciudadResidenciaConductor
     *
     * @return SvIpatConductor
     */
    public function setCiudadResidenciaConductor($ciudadResidenciaConductor)
    {
        $this->ciudadResidenciaConductor = $ciudadResidenciaConductor;

        return $this;
    }

    /**
     * Get ciudadResidenciaConductor
     *
     * @return string
     */
    public function getCiudadResidenciaConductor()
    {
        return $this->ciudadResidenciaConductor;
    }

    /**
     * Set telefonoConductor
     *
     * @param string $telefonoConductor
     *
     * @return SvIpatConductor
     */
    public function setTelefonoConductor($telefonoConductor)
    {
        $this->telefonoConductor = $telefonoConductor;

        return $this;
    }

    /**
     * Get telefonoConductor
     *
     * @return string
     */
    public function getTelefonoConductor()
    {
        return $this->telefonoConductor;
    }

    /**
     * Set practicoExamenConductor
     *
     * @param boolean $practicoExamenConductor
     *
     * @return SvIpatConductor
     */
    public function setPracticoExamenConductor($practicoExamenConductor)
    {
        $this->practicoExamenConductor = $practicoExamenConductor;

        return $this;
    }

    /**
     * Get practicoExamenConductor
     *
     * @return boolean
     */
    public function getPracticoExamenConductor()
    {
        return $this->practicoExamenConductor;
    }

    /**
     * Set autorizoConductor
     *
     * @param boolean $autorizoConductor
     *
     * @return SvIpatConductor
     */
    public function setAutorizoConductor($autorizoConductor)
    {
        $this->autorizoConductor = $autorizoConductor;

        return $this;
    }

    /**
     * Get autorizoConductor
     *
     * @return boolean
     */
    public function getAutorizoConductor()
    {
        return $this->autorizoConductor;
    }

    /**
     * Set sustanciasPsicoactivasConductor
     *
     * @param boolean $sustanciasPsicoactivasConductor
     *
     * @return SvIpatConductor
     */
    public function setSustanciasPsicoactivasConductor($sustanciasPsicoactivasConductor)
    {
        $this->sustanciasPsicoactivasConductor = $sustanciasPsicoactivasConductor;

        return $this;
    }

    /**
     * Get sustanciasPsicoactivasConductor
     *
     * @return boolean
     */
    public function getSustanciasPsicoactivasConductor()
    {
        return $this->sustanciasPsicoactivasConductor;
    }

    /**
     * Set portaLicencia
     *
     * @param boolean $portaLicencia
     *
     * @return SvIpatConductor
     */
    public function setPortaLicencia($portaLicencia)
    {
        $this->portaLicencia = $portaLicencia;

        return $this;
    }

    /**
     * Get portaLicencia
     *
     * @return boolean
     */
    public function getPortaLicencia()
    {
        return $this->portaLicencia;
    }

    /**
     * Set numeroLicenciaConduccion
     *
     * @param integer $numeroLicenciaConduccion
     *
     * @return SvIpatConductor
     */
    public function setNumeroLicenciaConduccion($numeroLicenciaConduccion)
    {
        $this->numeroLicenciaConduccion = $numeroLicenciaConduccion;

        return $this;
    }

    /**
     * Get numeroLicenciaConduccion
     *
     * @return integer
     */
    public function getNumeroLicenciaConduccion()
    {
        return $this->numeroLicenciaConduccion;
    }

    /**
     * Set categoriaLicenciaConduccion
     *
     * @param string $categoriaLicenciaConduccion
     *
     * @return SvIpatConductor
     */
    public function setCategoriaLicenciaConduccion($categoriaLicenciaConduccion)
    {
        $this->categoriaLicenciaConduccion = $categoriaLicenciaConduccion;

        return $this;
    }

    /**
     * Get categoriaLicenciaConduccion
     *
     * @return string
     */
    public function getCategoriaLicenciaConduccion()
    {
        return $this->categoriaLicenciaConduccion;
    }

    /**
     * Set restriccionConductor
     *
     * @param string $restriccionConductor
     *
     * @return SvIpatConductor
     */
    public function setRestriccionConductor($restriccionConductor)
    {
        $this->restriccionConductor = $restriccionConductor;

        return $this;
    }

    /**
     * Get restriccionConductor
     *
     * @return string
     */
    public function getRestriccionConductor()
    {
        return $this->restriccionConductor;
    }

    /**
     * Set fechaExpedicionLicenciaConduccion
     *
     * @param \DateTime $fechaExpedicionLicenciaConduccion
     *
     * @return SvIpatConductor
     */
    public function setFechaExpedicionLicenciaConduccion($fechaExpedicionLicenciaConduccion)
    {
        $this->fechaExpedicionLicenciaConduccion = $fechaExpedicionLicenciaConduccion;

        return $this;
    }

    /**
     * Get fechaExpedicionLicenciaConduccion
     *
     * @return \DateTime
     */
    public function getFechaExpedicionLicenciaConduccion()
    {
        return $this->fechaExpedicionLicenciaConduccion;
    }

    /**
     * Set fechaVencimientoLicenciaConduccion
     *
     * @param \DateTime $fechaVencimientoLicenciaConduccion
     *
     * @return SvIpatConductor
     */
    public function setFechaVencimientoLicenciaConduccion($fechaVencimientoLicenciaConduccion)
    {
        $this->fechaVencimientoLicenciaConduccion = $fechaVencimientoLicenciaConduccion;

        return $this;
    }

    /**
     * Get fechaVencimientoLicenciaConduccion
     *
     * @return \DateTime
     */
    public function getFechaVencimientoLicenciaConduccion()
    {
        return $this->fechaVencimientoLicenciaConduccion;
    }

    /**
     * Set organismoTransito
     *
     * @param string $organismoTransito
     *
     * @return SvIpatConductor
     */
    public function setOrganismoTransito($organismoTransito)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return string
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }

    /**
     * Set chalecoConductor
     *
     * @param boolean $chalecoConductor
     *
     * @return SvIpatConductor
     */
    public function setChalecoConductor($chalecoConductor)
    {
        $this->chalecoConductor = $chalecoConductor;

        return $this;
    }

    /**
     * Get chalecoConductor
     *
     * @return boolean
     */
    public function getChalecoConductor()
    {
        return $this->chalecoConductor;
    }

    /**
     * Set cascoConductor
     *
     * @param boolean $cascoConductor
     *
     * @return SvIpatConductor
     */
    public function setCascoConductor($cascoConductor)
    {
        $this->cascoConductor = $cascoConductor;

        return $this;
    }

    /**
     * Get cascoConductor
     *
     * @return boolean
     */
    public function getCascoConductor()
    {
        return $this->cascoConductor;
    }

    /**
     * Set cinturonConductor
     *
     * @param boolean $cinturonConductor
     *
     * @return SvIpatConductor
     */
    public function setCinturonConductor($cinturonConductor)
    {
        $this->cinturonConductor = $cinturonConductor;

        return $this;
    }

    /**
     * Get cinturonConductor
     *
     * @return boolean
     */
    public function getCinturonConductor()
    {
        return $this->cinturonConductor;
    }

    /**
     * Set placaVehiculoConductor
     *
     * @param string $placaVehiculoConductor
     *
     * @return SvIpatConductor
     */
    public function setPlacaVehiculoConductor($placaVehiculoConductor)
    {
        $this->placaVehiculoConductor = $placaVehiculoConductor;

        return $this;
    }

    /**
     * Get placaVehiculoConductor
     *
     * @return string
     */
    public function getPlacaVehiculoConductor()
    {
        return $this->placaVehiculoConductor;
    }

    /**
     * Set descripcionLesionConductor
     *
     * @param string $descripcionLesionConductor
     *
     * @return SvIpatConductor
     */
    public function setDescripcionLesionConductor($descripcionLesionConductor)
    {
        $this->descripcionLesionConductor = $descripcionLesionConductor;

        return $this;
    }

    /**
     * Get descripcionLesionConductor
     *
     * @return string
     */
    public function getDescripcionLesionConductor()
    {
        return $this->descripcionLesionConductor;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvIpatConductor
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
     * Set gravedadConductor
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedadConductor
     *
     * @return SvIpatConductor
     */
    public function setGravedadConductor(\JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedadConductor = null)
    {
        $this->gravedadConductor = $gravedadConductor;

        return $this;
    }

    /**
     * Get gravedadConductor
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima
     */
    public function getGravedadConductor()
    {
        return $this->gravedadConductor;
    }

    /**
     * Set resultadoExamenConductor
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamenConductor
     *
     * @return SvIpatConductor
     */
    public function setResultadoExamenConductor(\JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamenConductor = null)
    {
        $this->resultadoExamenConductor = $resultadoExamenConductor;

        return $this;
    }

    /**
     * Get resultadoExamenConductor
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen
     */
    public function getResultadoExamenConductor()
    {
        return $this->resultadoExamenConductor;
    }

    /**
     * Set gradoExamenConductor
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamenConductor
     *
     * @return SvIpatConductor
     */
    public function setGradoExamenConductor(\JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamenConductor = null)
    {
        $this->gradoExamenConductor = $gradoExamenConductor;

        return $this;
    }

    /**
     * Get gradoExamenConductor
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen
     */
    public function getGradoExamenConductor()
    {
        return $this->gradoExamenConductor;
    }

    /**
     * Set hospitalConductor
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospitalConductor
     *
     * @return SvIpatConductor
     */
    public function setHospitalConductor(\JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospitalConductor = null)
    {
        $this->hospitalConductor = $hospitalConductor;

        return $this;
    }

    /**
     * Get hospitalConductor
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital
     */
    public function getHospitalConductor()
    {
        return $this->hospitalConductor;
    }

    /**
     * Set consecutivo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo
     *
     * @return SvIpatConductor
     */
    public function setConsecutivo(\JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }
}
