<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatVictima
 *
 * @ORM\Table(name="sv_ipat_victima")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatVictimaRepository")
 */
class SvIpatVictima
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
     * @var bool
     *
     * @ORM\Column(name="practico_examen", type="boolean", nullable = true)
     */
    private $practicoExamen;

    /**
     * @var bool
     *
     * @ORM\Column(name="autorizo", type="boolean", nullable = true)
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
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVictima", inversedBy="tiposvictima")
     */
    private $tipoVictima;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima", inversedBy="gravedades")
     */
    private $gravedad;

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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * Set placaVehiculo
     *
     * @param string $placaVehiculo
     *
     * @return SvIpatVictima
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
     * Set practicoExamen
     *
     * @param boolean $practicoExamen
     *
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * Set chaleco
     *
     * @param boolean $chaleco
     *
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * Set descripcionLesion
     *
     * @param string $descripcionLesion
     *
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * Set hospital
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospital
     *
     * @return SvIpatVictima
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
     * Set resultadoExamen
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamen
     *
     * @return SvIpatVictima
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
     * @return SvIpatVictima
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
     * Set tipoVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVictima $tipoVictima
     *
     * @return SvIpatVictima
     */
    public function setTipoVictima(\JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVictima $tipoVictima = null)
    {
        $this->tipoVictima = $tipoVictima;

        return $this;
    }

    /**
     * Get tipoVictima
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgTipoVictima
     */
    public function getTipoVictima()
    {
        return $this->tipoVictima;
    }

    /**
     * Set gravedad
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedad
     *
     * @return SvIpatVictima
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
     * Set consecutivo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatConsecutivo $consecutivo
     *
     * @return SvIpatVictima
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
