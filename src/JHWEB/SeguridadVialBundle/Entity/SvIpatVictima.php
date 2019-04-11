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
     * @ORM\Column(name="nombres_victima", type="string", nullable = true)
     */
    private $nombresVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_victima", type="string", nullable = true)
     */
    private $apellidosVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_victima", type="string", nullable = true)
     */
    private $tipoIdentificacionVictima;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion_victima", type="integer", nullable = true)
     */
    private $identificacionVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad_victima", type="string", nullable = true)
     */
    private $nacionalidadVictima;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento_victima", type="date", nullable = true)
     */
    private $fechaNacimientoVictima;

    /**
     * @var int
     *
     * @ORM\Column(name="edad_victima", type="integer", nullable = true)
     */
    private $edadVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo_victima", type="string", nullable = true)
     */
    private $sexoVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_residencia_victima", type="string", nullable = true)
     */
    private $direccionResidenciaVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad_residencia_victima", type="string", nullable = true)
     */
    private $ciudadResidenciaVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_victima", type="string", nullable = true)
     */
    private $telefonoVictima;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgHospital", inversedBy="hospitales")
     */
    private $hospitalVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_vehiculo_victima", type="string", nullable = true)
     */
    private $placaVehiculoVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="practico_examen_victima", type="boolean", nullable = true)
     */
    private $practicoExamenVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="autorizo_victima", type="boolean", nullable = true)
     */
    private $autorizoVictima;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen", inversedBy="resultadosexamen")
     */
    private $resultadoExamenVictima;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen", inversedBy="gradosexamen")
     */
    private $gradoExamenVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="sustancias_psicoactivas_victima", type="boolean", nullable = true)
     */
    private $sustanciasPsicoactivasVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="chaleco_victima", type="boolean", nullable = true)
     */
    private $chalecoVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="casco_victima", type="boolean", nullable = true)
     */
    private $cascoVictima;

    /**
     * @var bool
     *
     * @ORM\Column(name="cinturon_victima", type="boolean", nullable = true)
     */
    private $cinturonVictima;
    
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
    private $gravedadVictima;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_lesion_victima", type="string", nullable = true)
     */
    private $descripcionLesionVictima;

    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat", inversedBy="victimas")
     */
    private $ipat;

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
     * Set nombresVictima
     *
     * @param string $nombresVictima
     *
     * @return SvIpatVictima
     */
    public function setNombresVictima($nombresVictima)
    {
        $this->nombresVictima = $nombresVictima;

        return $this;
    }

    /**
     * Get nombresVictima
     *
     * @return string
     */
    public function getNombresVictima()
    {
        return $this->nombresVictima;
    }

    /**
     * Set apellidosVictima
     *
     * @param string $apellidosVictima
     *
     * @return SvIpatVictima
     */
    public function setApellidosVictima($apellidosVictima)
    {
        $this->apellidosVictima = $apellidosVictima;

        return $this;
    }

    /**
     * Get apellidosVictima
     *
     * @return string
     */
    public function getApellidosVictima()
    {
        return $this->apellidosVictima;
    }

    /**
     * Set tipoIdentificacionVictima
     *
     * @param string $tipoIdentificacionVictima
     *
     * @return SvIpatVictima
     */
    public function setTipoIdentificacionVictima($tipoIdentificacionVictima)
    {
        $this->tipoIdentificacionVictima = $tipoIdentificacionVictima;

        return $this;
    }

    /**
     * Get tipoIdentificacionVictima
     *
     * @return string
     */
    public function getTipoIdentificacionVictima()
    {
        return $this->tipoIdentificacionVictima;
    }

    /**
     * Set identificacionVictima
     *
     * @param integer $identificacionVictima
     *
     * @return SvIpatVictima
     */
    public function setIdentificacionVictima($identificacionVictima)
    {
        $this->identificacionVictima = $identificacionVictima;

        return $this;
    }

    /**
     * Get identificacionVictima
     *
     * @return integer
     */
    public function getIdentificacionVictima()
    {
        return $this->identificacionVictima;
    }

    /**
     * Set nacionalidadVictima
     *
     * @param string $nacionalidadVictima
     *
     * @return SvIpatVictima
     */
    public function setNacionalidadVictima($nacionalidadVictima)
    {
        $this->nacionalidadVictima = $nacionalidadVictima;

        return $this;
    }

    /**
     * Get nacionalidadVictima
     *
     * @return string
     */
    public function getNacionalidadVictima()
    {
        return $this->nacionalidadVictima;
    }

    /**
     * Set fechaNacimientoVictima
     *
     * @param \DateTime $fechaNacimientoVictima
     *
     * @return SvIpatVictima
     */
    public function setFechaNacimientoVictima($fechaNacimientoVictima)
    {
        $this->fechaNacimientoVictima = $fechaNacimientoVictima;

        return $this;
    }

    /**
     * Get fechaNacimientoVictima
     *
     * @return \DateTime
     */
    public function getFechaNacimientoVictima()
    {
        return $this->fechaNacimientoVictima;
    }

    /**
     * Set edadVictima
     *
     * @param integer $edadVictima
     *
     * @return SvIpatVictima
     */
    public function setEdadVictima($edadVictima)
    {
        $this->edadVictima = $edadVictima;

        return $this;
    }

    /**
     * Get edadVictima
     *
     * @return integer
     */
    public function getEdadVictima()
    {
        return $this->edadVictima;
    }

    /**
     * Set sexoVictima
     *
     * @param string $sexoVictima
     *
     * @return SvIpatVictima
     */
    public function setSexoVictima($sexoVictima)
    {
        $this->sexoVictima = $sexoVictima;

        return $this;
    }

    /**
     * Get sexoVictima
     *
     * @return string
     */
    public function getSexoVictima()
    {
        return $this->sexoVictima;
    }

    /**
     * Set direccionResidenciaVictima
     *
     * @param string $direccionResidenciaVictima
     *
     * @return SvIpatVictima
     */
    public function setDireccionResidenciaVictima($direccionResidenciaVictima)
    {
        $this->direccionResidenciaVictima = $direccionResidenciaVictima;

        return $this;
    }

    /**
     * Get direccionResidenciaVictima
     *
     * @return string
     */
    public function getDireccionResidenciaVictima()
    {
        return $this->direccionResidenciaVictima;
    }

    /**
     * Set ciudadResidenciaVictima
     *
     * @param string $ciudadResidenciaVictima
     *
     * @return SvIpatVictima
     */
    public function setCiudadResidenciaVictima($ciudadResidenciaVictima)
    {
        $this->ciudadResidenciaVictima = $ciudadResidenciaVictima;

        return $this;
    }

    /**
     * Get ciudadResidenciaVictima
     *
     * @return string
     */
    public function getCiudadResidenciaVictima()
    {
        return $this->ciudadResidenciaVictima;
    }

    /**
     * Set telefonoVictima
     *
     * @param string $telefonoVictima
     *
     * @return SvIpatVictima
     */
    public function setTelefonoVictima($telefonoVictima)
    {
        $this->telefonoVictima = $telefonoVictima;

        return $this;
    }

    /**
     * Get telefonoVictima
     *
     * @return string
     */
    public function getTelefonoVictima()
    {
        return $this->telefonoVictima;
    }

    /**
     * Set placaVehiculoVictima
     *
     * @param string $placaVehiculoVictima
     *
     * @return SvIpatVictima
     */
    public function setPlacaVehiculoVictima($placaVehiculoVictima)
    {
        $this->placaVehiculoVictima = $placaVehiculoVictima;

        return $this;
    }

    /**
     * Get placaVehiculoVictima
     *
     * @return string
     */
    public function getPlacaVehiculoVictima()
    {
        return $this->placaVehiculoVictima;
    }

    /**
     * Set practicoExamenVictima
     *
     * @param boolean $practicoExamenVictima
     *
     * @return SvIpatVictima
     */
    public function setPracticoExamenVictima($practicoExamenVictima)
    {
        $this->practicoExamenVictima = $practicoExamenVictima;

        return $this;
    }

    /**
     * Get practicoExamenVictima
     *
     * @return boolean
     */
    public function getPracticoExamenVictima()
    {
        return $this->practicoExamenVictima;
    }

    /**
     * Set autorizoVictima
     *
     * @param boolean $autorizoVictima
     *
     * @return SvIpatVictima
     */
    public function setAutorizoVictima($autorizoVictima)
    {
        $this->autorizoVictima = $autorizoVictima;

        return $this;
    }

    /**
     * Get autorizoVictima
     *
     * @return boolean
     */
    public function getAutorizoVictima()
    {
        return $this->autorizoVictima;
    }

    /**
     * Set sustanciasPsicoactivasVictima
     *
     * @param boolean $sustanciasPsicoactivasVictima
     *
     * @return SvIpatVictima
     */
    public function setSustanciasPsicoactivasVictima($sustanciasPsicoactivasVictima)
    {
        $this->sustanciasPsicoactivasVictima = $sustanciasPsicoactivasVictima;

        return $this;
    }

    /**
     * Get sustanciasPsicoactivasVictima
     *
     * @return boolean
     */
    public function getSustanciasPsicoactivasVictima()
    {
        return $this->sustanciasPsicoactivasVictima;
    }

    /**
     * Set chalecoVictima
     *
     * @param boolean $chalecoVictima
     *
     * @return SvIpatVictima
     */
    public function setChalecoVictima($chalecoVictima)
    {
        $this->chalecoVictima = $chalecoVictima;

        return $this;
    }

    /**
     * Get chalecoVictima
     *
     * @return boolean
     */
    public function getChalecoVictima()
    {
        return $this->chalecoVictima;
    }

    /**
     * Set cascoVictima
     *
     * @param boolean $cascoVictima
     *
     * @return SvIpatVictima
     */
    public function setCascoVictima($cascoVictima)
    {
        $this->cascoVictima = $cascoVictima;

        return $this;
    }

    /**
     * Get cascoVictima
     *
     * @return boolean
     */
    public function getCascoVictima()
    {
        return $this->cascoVictima;
    }

    /**
     * Set cinturonVictima
     *
     * @param boolean $cinturonVictima
     *
     * @return SvIpatVictima
     */
    public function setCinturonVictima($cinturonVictima)
    {
        $this->cinturonVictima = $cinturonVictima;

        return $this;
    }

    /**
     * Get cinturonVictima
     *
     * @return boolean
     */
    public function getCinturonVictima()
    {
        return $this->cinturonVictima;
    }

    /**
     * Set descripcionLesionVictima
     *
     * @param string $descripcionLesionVictima
     *
     * @return SvIpatVictima
     */
    public function setDescripcionLesionVictima($descripcionLesionVictima)
    {
        $this->descripcionLesionVictima = $descripcionLesionVictima;

        return $this;
    }

    /**
     * Get descripcionLesionVictima
     *
     * @return string
     */
    public function getDescripcionLesionVictima()
    {
        return $this->descripcionLesionVictima;
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
     * Set hospitalVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospitalVictima
     *
     * @return SvIpatVictima
     */
    public function setHospitalVictima(\JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospitalVictima = null)
    {
        $this->hospitalVictima = $hospitalVictima;

        return $this;
    }

    /**
     * Get hospitalVictima
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital
     */
    public function getHospitalVictima()
    {
        return $this->hospitalVictima;
    }

    /**
     * Set resultadoExamenVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamenVictima
     *
     * @return SvIpatVictima
     */
    public function setResultadoExamenVictima(\JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen $resultadoExamenVictima = null)
    {
        $this->resultadoExamenVictima = $resultadoExamenVictima;

        return $this;
    }

    /**
     * Get resultadoExamenVictima
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgResultadoExamen
     */
    public function getResultadoExamenVictima()
    {
        return $this->resultadoExamenVictima;
    }

    /**
     * Set gradoExamenVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamenVictima
     *
     * @return SvIpatVictima
     */
    public function setGradoExamenVictima(\JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen $gradoExamenVictima = null)
    {
        $this->gradoExamenVictima = $gradoExamenVictima;

        return $this;
    }

    /**
     * Get gradoExamenVictima
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGradoExamen
     */
    public function getGradoExamenVictima()
    {
        return $this->gradoExamenVictima;
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
     * Set gravedadVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedadVictima
     *
     * @return SvIpatVictima
     */
    public function setGravedadVictima(\JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedadVictima = null)
    {
        $this->gravedadVictima = $gravedadVictima;

        return $this;
    }

    /**
     * Get gravedadVictima
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima
     */
    public function getGravedadVictima()
    {
        return $this->gravedadVictima;
    }

    /**
     * Set ipat
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat $ipat
     *
     * @return SvIpatVictima
     */
    public function setIpat(\JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat $ipat = null)
    {
        $this->ipat = $ipat;

        return $this;
    }

    /**
     * Get ipat
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvRegistroIpat
     */
    public function getIpat()
    {
        return $this->ipat;
    }
}
