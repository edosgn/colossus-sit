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
     * @ORM\Column(name="nombres", type="string", nullable = true)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", nullable = true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion", type="string", nullable = true)
     */
    private $tipoIdentificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion", type="integer", nullable = true)
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad", type="string", nullable = true)
     */
    private $nacionalidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable = true)
     */
    private $fechaNacimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer", nullable = true)
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", nullable = true)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima", inversedBy="gravedades")
     */
    private $gravedad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_residencia", type="string", nullable = true)
     */
    private $direccionResidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad_residencia", type="string", nullable = true)
     */
    private $ciudadResidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", nullable = true)
     */
    private $telefono;

    /**
     * @var bool
     *
     * @ORM\Column(name="practico_examen", type="boolean", nullable = true)
     */
    private $practicoExamen;

    /**
     * @var bool
     *
     * @ORM\Column(name="autorizo_onductor", type="boolean", nullable = true)
     */
    private $autorizo;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen", inversedBy="resultadosexamen")
     */
    private $resultadoExamen;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen", inversedBy="gradosexamen")
     */
    private $gradoExamen;

    /**
     * @var bool
     *
     * @ORM\Column(name="sustancias_psicoactivas", type="boolean", nullable = true)
     */
    private $sustanciasPsicoactivas;

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
     * @ORM\Column(name="restriccion_licencia", type="string", nullable = true)
     */
    private $restriccionLicencia;

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
     * @ORM\Column(name="chaleco", type="boolean", nullable = true)
     */
    private $chaleco;

    /**
     * @var bool
     *
     * @ORM\Column(name="casco", type="boolean", nullable = true)
     */
    private $casco;

    /**
     * @var bool
     *
     * @ORM\Column(name="cinturon", type="boolean", nullable = true)
     */
    private $cinturon;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgHospital", inversedBy="hospitales")
     */
    private $hospital;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_vehiculo", type="string", nullable = true)
     */
    private $placaVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_lesion", type="string", nullable = true)
     */
    private $descripcionLesion;

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
     * Set nombres
     *
     * @param string $nombres
     *
     * @return SvIpatConductor
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return SvIpatConductor
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set tipoIdentificacion
     *
     * @param string $tipoIdentificacion
     *
     * @return SvIpatConductor
     */
    public function setTipoIdentificacion($tipoIdentificacion)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return string
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
    }

    /**
     * Set identificacion
     *
     * @param integer $identificacion
     *
     * @return SvIpatConductor
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return integer
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return SvIpatConductor
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return SvIpatConductor
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     *
     * @return SvIpatConductor
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return SvIpatConductor
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set direccionResidencia
     *
     * @param string $direccionResidencia
     *
     * @return SvIpatConductor
     */
    public function setDireccionResidencia($direccionResidencia)
    {
        $this->direccionResidencia = $direccionResidencia;

        return $this;
    }

    /**
     * Get direccionResidencia
     *
     * @return string
     */
    public function getDireccionResidencia()
    {
        return $this->direccionResidencia;
    }

    /**
     * Set ciudadResidencia
     *
     * @param string $ciudadResidencia
     *
     * @return SvIpatConductor
     */
    public function setCiudadResidencia($ciudadResidencia)
    {
        $this->ciudadResidencia = $ciudadResidencia;

        return $this;
    }

    /**
     * Get ciudadResidencia
     *
     * @return string
     */
    public function getCiudadResidencia()
    {
        return $this->ciudadResidencia;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return SvIpatConductor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set practicoExamen
     *
     * @param boolean $practicoExamen
     *
     * @return SvIpatConductor
     */
    public function setPracticoExamen($practicoExamen)
    {
        $this->practicoExamen = $practicoExamen;

        return $this;
    }

    /**
     * Get practicoExamen
     *
     * @return boolean
     */
    public function getPracticoExamen()
    {
        return $this->practicoExamen;
    }

    /**
     * Set autorizo
     *
     * @param boolean $autorizo
     *
     * @return SvIpatConductor
     */
    public function setAutorizo($autorizo)
    {
        $this->autorizo = $autorizo;

        return $this;
    }

    /**
     * Get autorizo
     *
     * @return boolean
     */
    public function getAutorizo()
    {
        return $this->autorizo;
    }

    /**
     * Set sustanciasPsicoactivas
     *
     * @param boolean $sustanciasPsicoactivas
     *
     * @return SvIpatConductor
     */
    public function setSustanciasPsicoactivas($sustanciasPsicoactivas)
    {
        $this->sustanciasPsicoactivas = $sustanciasPsicoactivas;

        return $this;
    }

    /**
     * Get sustanciasPsicoactivas
     *
     * @return boolean
     */
    public function getSustanciasPsicoactivas()
    {
        return $this->sustanciasPsicoactivas;
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
     * Set restriccionLicencia
     *
     * @param string $restriccionLicencia
     *
     * @return SvIpatConductor
     */
    public function setRestriccionLicencia($restriccionLicencia)
    {
        $this->restriccionLicencia = $restriccionLicencia;

        return $this;
    }

    /**
     * Get restriccionLicencia
     *
     * @return string
     */
    public function getRestriccionLicencia()
    {
        return $this->restriccionLicencia;
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
     * Set chaleco
     *
     * @param boolean $chaleco
     *
     * @return SvIpatConductor
     */
    public function setChaleco($chaleco)
    {
        $this->chaleco = $chaleco;

        return $this;
    }

    /**
     * Get chaleco
     *
     * @return boolean
     */
    public function getChaleco()
    {
        return $this->chaleco;
    }

    /**
     * Set casco
     *
     * @param boolean $casco
     *
     * @return SvIpatConductor
     */
    public function setCasco($casco)
    {
        $this->casco = $casco;

        return $this;
    }

    /**
     * Get casco
     *
     * @return boolean
     */
    public function getCasco()
    {
        return $this->casco;
    }

    /**
     * Set cinturon
     *
     * @param boolean $cinturon
     *
     * @return SvIpatConductor
     */
    public function setCinturon($cinturon)
    {
        $this->cinturon = $cinturon;

        return $this;
    }

    /**
     * Get cinturon
     *
     * @return boolean
     */
    public function getCinturon()
    {
        return $this->cinturon;
    }

    /**
     * Set placaVehiculo
     *
     * @param string $placaVehiculo
     *
     * @return SvIpatConductor
     */
    public function setPlacaVehiculo($placaVehiculo)
    {
        $this->placaVehiculo = $placaVehiculo;

        return $this;
    }

    /**
     * Get placaVehiculo
     *
     * @return string
     */
    public function getPlacaVehiculo()
    {
        return $this->placaVehiculo;
    }

    /**
     * Set descripcionLesion
     *
     * @param string $descripcionLesion
     *
     * @return SvIpatConductor
     */
    public function setDescripcionLesion($descripcionLesion)
    {
        $this->descripcionLesion = $descripcionLesion;

        return $this;
    }

    /**
     * Get descripcionLesion
     *
     * @return string
     */
    public function getDescripcionLesion()
    {
        return $this->descripcionLesion;
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
     * Set gravedad
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedad
     *
     * @return SvIpatConductor
     */
    public function setGravedad(\JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedad = null)
    {
        $this->gravedad = $gravedad;

        return $this;
    }

    /**
     * Get gravedad
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima
     */
    public function getGravedad()
    {
        return $this->gravedad;
    }

    /**
     * Set resultadoExamen
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamen
     *
     * @return SvIpatConductor
     */
    public function setResultadoExamen(\JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamen = null)
    {
        $this->resultadoExamen = $resultadoExamen;

        return $this;
    }

    /**
     * Get resultadoExamen
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen
     */
    public function getResultadoExamen()
    {
        return $this->resultadoExamen;
    }

    /**
     * Set gradoExamen
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamen
     *
     * @return SvIpatConductor
     */
    public function setGradoExamen(\JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamen = null)
    {
        $this->gradoExamen = $gradoExamen;

        return $this;
    }

    /**
     * Get gradoExamen
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen
     */
    public function getGradoExamen()
    {
        return $this->gradoExamen;
    }

    /**
     * Set hospital
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospital
     *
     * @return SvIpatConductor
     */
    public function setHospital(\JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospital = null)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Get hospital
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital
     */
    public function getHospital()
    {
        return $this->hospital;
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
