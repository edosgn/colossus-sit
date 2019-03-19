<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvRegistroIpat
 *
 * @ORM\Table(name="sv_registro_ipat")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvRegistroIpatRepository")
 */
class SvRegistroIpat
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvTConsecutivo", inversedBy="consecutivos")
     */
    private $consecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", nullable = true)
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_accidente", type="date", nullable = true)
     */
    private $fechaAccidente;

    /**
     * @var string
     *
     * @ORM\Column(name="dia_accidente", type="string", nullable = true)
     */
    private $diaAccidente;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_accidente", type="time", nullable = true)
     */
    private $horaAccidente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_levantamiento", type="date", nullable = true)
     */
    private $fechaLevantamiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_levantamiento", type="time", nullable = true)
     */
    private $horaLevantamiento;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="ipats")
     */
    private $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgGravedad", inversedBy="gravedades")
     */
    private $gravedad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente", inversedBy="clasesaccidentes")
     */
    private $claseAccidente;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_clase_accidente", type="string", nullable = true)
     */
    private $otroClaseAccidente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgChoqueCon", inversedBy="choquescon")
     */
    private $choqueCon;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgObjetoFijo", inversedBy="objetosfijos")
     */
    private $objetoFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_objeto_fijo", type="string", nullable = true)
     */
    private $otroObjetoFijo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgArea", inversedBy="areas")
     */
    private $area;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgSector", inversedBy="sectores")
     */
    private $sector;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgZona", inversedBy="zonas")
     */
    private $zona;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio", inversedBy="disenios")
     */
    private $disenio;

    /**
     * @var array
     *
     * @ORM\Column(name="estado_tiempo", type="array", nullable=true)
     */
    private $estadoTiempo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria", inversedBy="geometrias")
     */
    private $geometria;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion", inversedBy="utilizaciones")
     */
    private $utilizacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril", inversedBy="calzadas")
     */
    private $calzada;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril", inversedBy="carriles")
     */
    private $carril;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial", inversedBy="materiales")
     */
    private $material;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia", inversedBy="estadosvia")
     */
    private $estadoVia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia", inversedBy="condicionesvia")
     */
    private $condicionVia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion", inversedBy="iuminaciones")
     */
    private $iluminacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion", inversedBy="estadosiluminacion")
     */
    private $estadoIluminacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgVisual", inversedBy="visuales")
     */
    private $visual;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida", inversedBy="visualesdisminuidas")
     */
    private $visualDisminuida;

    /**
     * @var string
     *
     * @ORM\Column(name="otra_visualDisminuida", type="string", nullable = true)
     */
    private $otraVisualDisminuida;

    /**
     * @var string
     *
     * @ORM\Column(name="semaforo", type="string", nullable = true)
     */
    private $semaforo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia", inversedBy="estadossemaforo")
     */
    private $estadoSemaforo;

    /**
     * @var array
     *
     * @ORM\Column(name="senial_vertical", type="array", nullable=true)
     */
    private $senialVertical;

    /**
     * @var array
     *
     * @ORM\Column(name="senial_horizontal", type="array", nullable=true)
     */
    private $senialHorizontal;

    /**
     * @var array
     *
     * @ORM\Column(name="reductor_velocidad", type="array", nullable=true)
     */
    private $reductorVelocidad;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_reductor_velocidad", type="string", nullable=true)
     */
    private $otroReductorVelocidad;

    /**
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia", inversedBy="delineadores_piso")
     */
    private $delineadorPiso;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_delineador_piso", type="string", nullable=true)
     */
    private $otroDelineadorPiso;

    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", nullable = true)
     */
    private $placa;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_remolque", type="string", nullable = true)
     */
    private $placaRemolque;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidadVehiculo", type="string", nullable = true)
     */
    private $nacionalidadVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", nullable = true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="linea", type="string", nullable = true)
     */
    private $linea;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", nullable = true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", nullable = true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="carroceria", type="string", nullable = true)
     */
    private $carroceria;

    /**
     * @var string
     *
     * @ORM\Column(name="ton", type="string", nullable = true)
     */
    private $ton;

    /**
     * @var string
     *
     * @ORM\Column(name="pasajeros", type="string", nullable = true)
     */
    private $pasajeros;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", nullable = true)
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="nitEmpresa", type="string", nullable = true)
     */
    private $nitEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="matriculado_en", type="string", nullable = true)
     */
    private $matriculadoEn;

    /**
     * @var string
     *
     * @ORM\Column(name="inmovilizado_en", type="string", nullable = true)
     */
    private $inmovilizadoEn;

    /**
     * @var string
     *
     * @ORM\Column(name="a_disposicion_de", type="string", nullable = true)
     */
    private $aDisposicionDe;

    /**
     * @var string
     *
     * @ORM\Column(name="tarjeta_registro", type="string", nullable = true)
     */
    private $tarjetaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="revision_tecnomecanica", type="string", nullable = true)
     */
    private $revisionTecnoMecanica;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_tecnomecanica", type="string", nullable = true)
     */
    private $numeroTecnoMecanica;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad_acompaniantes", type="string", nullable = true)
     */
    private $cantidadAcompaniantes;

    /**
     * @var string
     *
     * @ORM\Column(name="portaSoat", type="string", nullable = true)
     */
    private $portaSoat;

    /**
     * @var int
     *
     * @ORM\Column(name="soat", type="integer", nullable = true)
     */
    private $soat;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroPoliza", type="integer", nullable = true)
     */
    private $numeroPoliza;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_soat", type="string", nullable = true)
     */
    private $aseguradoraSoat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_soat", type="date", nullable = true)
     */
    private $fechaVencimientoSoat;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_seguro_responsabilidad_civil", type="boolean", nullable = true)
     */
    private $portaSeguroResponsabilidadCivil;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_seguro_responsabilidad_civil", type="integer", nullable = true)
     */
    private $numeroSeguroResponsabilidadCivil;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_seguro_responsabilidad_civil", type="string", nullable = true)
     */
    private $aseguradoraSeguroResponsabilidadCivil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_seguro_responsabilidad_civil", type="date", nullable = true)
     */
    private $fechaVencimientoSeguroResponsabilidadCivil;

    /**
     * @var bool
     *
     * @ORM\Column(name="porta_seguro_extracontractual", type="boolean", nullable = true)
     */
    private $portaSeguroExtracontractual;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_seguro_extracontractual", type="integer", nullable = true)
     */
    private $numeroSeguroExtracontractual;

    /**
     * @var string
     *
     * @ORM\Column(name="aseguradora_seguro_extracontractual", type="string", nullable = true)
     */
    private $aseguradoraSeguroExtracontractual;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_seguro_extracontractual", type="date", nullable = true)
     */
    private $fechaVencimientoSeguroExtracontractual;

    /**
     * @var bool
     *
     * @ORM\Column(name="mismo_conductor", type="boolean", nullable = true)
     */
    private $mismoConductor;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres_propietario", type="string", nullable = true)
     */
    private $nombresPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_propietario", type="string", nullable = true)
     */
    private $apellidosPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_propietario", type="string", nullable = true)
     */
    private $tipoIdentificacionPropietario;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion_propietario", type="integer", nullable = true)
     */
    private $identificacionPropietario;

    /**
     * @var string
     *
     * @ORM\Column(name="clase", type="string", nullable = true)
     */
    private $clase;

     /**
     * @var string
     *
     * @ORM\Column(name="servicio", type="string", nullable = true)
     */
    private $servicio;

     /**
     * @var string
     *
     * @ORM\Column(name="modalidad_transporte", type="string", nullable = true)
     */
    private $modalidadTransporte;

     /**
     * @var string
     *
     * @ORM\Column(name="radio_accion", type="string", nullable = true)
     */
    private $radioAccion;

     /**
     * @var string
     *
     * @ORM\Column(name="descripcion_danios", type="string", nullable = true)
     */
    private $descripcionDanios;

    /**
     * @var array
     *
     * @ORM\Column(name="falla", type="array", nullable=true)
     */
    private $falla;
    

    /**
     * @var array
     *
     * @ORM\Column(name="lugar_impacto", type="array", nullable=true)
     */
    private $lugarImpacto;

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
     * @ORM\Column(name="descripcion_lesion_conductor", type="string", nullable = true)
     */
    private $descripcionLesionConductor;

    /**
     * @var bool
     *
     * @ORM\Column(name="victima", type="boolean", nullable = true)
     */
    private $victima;

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
    private $plavaVehiculoVictima;

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
     * @ORM\Column(name="observaciones", type="string", nullable = true)
     */
    private $observaciones;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombres_testigo", type="string", nullable = true)
     */
    private $nombresTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_testigo", type="string", nullable = true)
     */
    private $apellidosTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_testigo", type="string", nullable = true)
     */
    private $tipoIdentificacionTestigo;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion_testigo", type="string", nullable = true)
     */
    private $identificacionTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="direccion_residencia_testigo", type="string", nullable = true)
     */
    private $direccionResidenciaTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudad_residencia_testigo", type="string", nullable = true)
     */
    private $ciudadResidenciaTestigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono_testigo", type="string", nullable = true)
     */
    private $telefonoTestigo;


    //datos del agente de transito
    /**
     * @var string
     *
     * @ORM\Column(name="grado_agente", type="string", nullable = true)
     */
    private $gradoAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombres_agente", type="string", nullable = true)
     */
    private $nombresAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos_agente", type="string", nullable = true)
     */
    private $apellidosAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_identificacion_agente", type="string", nullable = true)
     */
    private $tipoIdentificacionAgente;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion_agente", type="string", nullable = true)
     */
    private $identificacionAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="placa_agente", type="string", nullable = true)
     */
    private $placaAgente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="entidad_agente", type="string", nullable = true)
     */
    private $entidadAgente;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis", inversedBy="hipotesis")
     */
    private $hipotesis;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_peaton", type="string", nullable = true)
     */
    private $totalPeaton;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_acompaniante", type="string", nullable = true)
     */
    private $totalAcompaniante;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_pasajero", type="string", nullable = true)
     */
    private $totalPasajero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_conductor", type="string", nullable = true)
     */
    private $totalConductor;
    
    /**
     * @var string
     *
     * @ORM\Column(name="total_herido", type="string", nullable = true)
     */
    private $totalHerido;

    /**
     * @var string
     *
     * @ORM\Column(name="total_muerto", type="string", nullable = true)
     */
    private $totalMuerto;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="municipios")
     */
    private $municipioCorrespondio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente", inversedBy="entidadesaccidente")
     */
    private $entidadCorrespondio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora", inversedBy="unidadesreceptoras")
     */
    private $unidadCorrespondio;

    /**
     * @var int
     *
     * @ORM\Column(name="anio_correspondio", type="integer", nullable = true)
     */
    private $anioCorrespondio;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo_correspondio", type="integer", nullable = true)
     */
    private $consecutivoCorrespondio;

    /**
     * @var string
     *
     * @ORM\Column(name="correspondio", type="string", nullable = true)
     */
    private $correspondio;


    /**
     * @var array
     *
     * @ORM\Column(name="conductores", type="array", nullable=true)
     */
    private $conductores;


    /**
     * @var array
     *
     * @ORM\Column(name="vehiculos", type="array", nullable=true)
     */
    private $vehiculos;


    /**
     * @var array
     *
     * @ORM\Column(name="victimas", type="array", nullable=true)
     */
    private $victimas;

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
     * Set lugar
     *
     * @param string $lugar
     *
     * @return SvRegistroIpat
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fechaAccidente
     *
     * @param \DateTime $fechaAccidente
     *
     * @return SvRegistroIpat
     */
    public function setFechaAccidente($fechaAccidente)
    {
        $this->fechaAccidente = $fechaAccidente;

        return $this;
    }

    /**
     * Get fechaAccidente
     *
     * @return \DateTime
     */
    public function getFechaAccidente()
    {
        return $this->fechaAccidente;
    }

    /**
     * Set diaAccidente
     *
     * @param string $diaAccidente
     *
     * @return SvRegistroIpat
     */
    public function setDiaAccidente($diaAccidente)
    {
        $this->diaAccidente = $diaAccidente;

        return $this;
    }

    /**
     * Get diaAccidente
     *
     * @return string
     */
    public function getDiaAccidente()
    {
        return $this->diaAccidente;
    }

    /**
     * Set horaAccidente
     *
     * @param \DateTime $horaAccidente
     *
     * @return SvRegistroIpat
     */
    public function setHoraAccidente($horaAccidente)
    {
        $this->horaAccidente = $horaAccidente;

        return $this;
    }

    /**
     * Get horaAccidente
     *
     * @return \DateTime
     */
    public function getHoraAccidente()
    {
        return $this->horaAccidente;
    }

    /**
     * Set fechaLevantamiento
     *
     * @param \DateTime $fechaLevantamiento
     *
     * @return SvRegistroIpat
     */
    public function setFechaLevantamiento($fechaLevantamiento)
    {
        $this->fechaLevantamiento = $fechaLevantamiento;

        return $this;
    }

    /**
     * Get fechaLevantamiento
     *
     * @return \DateTime
     */
    public function getFechaLevantamiento()
    {
        return $this->fechaLevantamiento;
    }

    /**
     * Set horaLevantamiento
     *
     * @param \DateTime $horaLevantamiento
     *
     * @return SvRegistroIpat
     */
    public function setHoraLevantamiento($horaLevantamiento)
    {
        $this->horaLevantamiento = $horaLevantamiento;

        return $this;
    }

    /**
     * Get horaLevantamiento
     *
     * @return \DateTime
     */
    public function getHoraLevantamiento()
    {
        return $this->horaLevantamiento;
    }

    /**
     * Set otroClaseAccidente
     *
     * @param string $otroClaseAccidente
     *
     * @return SvRegistroIpat
     */
    public function setOtroClaseAccidente($otroClaseAccidente)
    {
        $this->otroClaseAccidente = $otroClaseAccidente;

        return $this;
    }

    /**
     * Get otroClaseAccidente
     *
     * @return string
     */
    public function getOtroClaseAccidente()
    {
        return $this->otroClaseAccidente;
    }

    /**
     * Set otroObjetoFijo
     *
     * @param string $otroObjetoFijo
     *
     * @return SvRegistroIpat
     */
    public function setOtroObjetoFijo($otroObjetoFijo)
    {
        $this->otroObjetoFijo = $otroObjetoFijo;

        return $this;
    }

    /**
     * Get otroObjetoFijo
     *
     * @return string
     */
    public function getOtroObjetoFijo()
    {
        return $this->otroObjetoFijo;
    }

    /**
     * Set estadoTiempo
     *
     * @param array $estadoTiempo
     *
     * @return SvRegistroIpat
     */
    public function setEstadoTiempo($estadoTiempo)
    {
        $this->estadoTiempo = $estadoTiempo;

        return $this;
    }

    /**
     * Get estadoTiempo
     *
     * @return array
     */
    public function getEstadoTiempo()
    {
        return $this->estadoTiempo;
    }

    /**
     * Set otraVisualDisminuida
     *
     * @param string $otraVisualDisminuida
     *
     * @return SvRegistroIpat
     */
    public function setOtraVisualDisminuida($otraVisualDisminuida)
    {
        $this->otraVisualDisminuida = $otraVisualDisminuida;

        return $this;
    }

    /**
     * Get otraVisualDisminuida
     *
     * @return string
     */
    public function getOtraVisualDisminuida()
    {
        return $this->otraVisualDisminuida;
    }

    /**
     * Set semaforo
     *
     * @param string $semaforo
     *
     * @return SvRegistroIpat
     */
    public function setSemaforo($semaforo)
    {
        $this->semaforo = $semaforo;

        return $this;
    }

    /**
     * Get semaforo
     *
     * @return string
     */
    public function getSemaforo()
    {
        return $this->semaforo;
    }

    /**
     * Set senialVertical
     *
     * @param array $senialVertical
     *
     * @return SvRegistroIpat
     */
    public function setSenialVertical($senialVertical)
    {
        $this->senialVertical = $senialVertical;

        return $this;
    }

    /**
     * Get senialVertical
     *
     * @return array
     */
    public function getSenialVertical()
    {
        return $this->senialVertical;
    }

    /**
     * Set senialHorizontal
     *
     * @param array $senialHorizontal
     *
     * @return SvRegistroIpat
     */
    public function setSenialHorizontal($senialHorizontal)
    {
        $this->senialHorizontal = $senialHorizontal;

        return $this;
    }

    /**
     * Get senialHorizontal
     *
     * @return array
     */
    public function getSenialHorizontal()
    {
        return $this->senialHorizontal;
    }

    /**
     * Set reductorVelocidad
     *
     * @param array $reductorVelocidad
     *
     * @return SvRegistroIpat
     */
    public function setReductorVelocidad($reductorVelocidad)
    {
        $this->reductorVelocidad = $reductorVelocidad;

        return $this;
    }

    /**
     * Get reductorVelocidad
     *
     * @return array
     */
    public function getReductorVelocidad()
    {
        return $this->reductorVelocidad;
    }

    /**
     * Set otroReductorVelocidad
     *
     * @param string $otroReductorVelocidad
     *
     * @return SvRegistroIpat
     */
    public function setOtroReductorVelocidad($otroReductorVelocidad)
    {
        $this->otroReductorVelocidad = $otroReductorVelocidad;

        return $this;
    }

    /**
     * Get otroReductorVelocidad
     *
     * @return string
     */
    public function getOtroReductorVelocidad()
    {
        return $this->otroReductorVelocidad;
    }

    /**
     * Set otroDelineadorPiso
     *
     * @param string $otroDelineadorPiso
     *
     * @return SvRegistroIpat
     */
    public function setOtroDelineadorPiso($otroDelineadorPiso)
    {
        $this->otroDelineadorPiso = $otroDelineadorPiso;

        return $this;
    }

    /**
     * Get otroDelineadorPiso
     *
     * @return string
     */
    public function getOtroDelineadorPiso()
    {
        return $this->otroDelineadorPiso;
    }

    /**
     * Set placa
     *
     * @param string $placa
     *
     * @return SvRegistroIpat
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
     * Set placaRemolque
     *
     * @param string $placaRemolque
     *
     * @return SvRegistroIpat
     */
    public function setPlacaRemolque($placaRemolque)
    {
        $this->placaRemolque = $placaRemolque;

        return $this;
    }

    /**
     * Get placaRemolque
     *
     * @return string
     */
    public function getPlacaRemolque()
    {
        return $this->placaRemolque;
    }

    /**
     * Set nacionalidadVehiculo
     *
     * @param string $nacionalidadVehiculo
     *
     * @return SvRegistroIpat
     */
    public function setNacionalidadVehiculo($nacionalidadVehiculo)
    {
        $this->nacionalidadVehiculo = $nacionalidadVehiculo;

        return $this;
    }

    /**
     * Get nacionalidadVehiculo
     *
     * @return string
     */
    public function getNacionalidadVehiculo()
    {
        return $this->nacionalidadVehiculo;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return SvRegistroIpat
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set linea
     *
     * @param string $linea
     *
     * @return SvRegistroIpat
     */
    public function setLinea($linea)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea
     *
     * @return string
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return SvRegistroIpat
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return SvRegistroIpat
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set carroceria
     *
     * @param string $carroceria
     *
     * @return SvRegistroIpat
     */
    public function setCarroceria($carroceria)
    {
        $this->carroceria = $carroceria;

        return $this;
    }

    /**
     * Get carroceria
     *
     * @return string
     */
    public function getCarroceria()
    {
        return $this->carroceria;
    }

    /**
     * Set ton
     *
     * @param string $ton
     *
     * @return SvRegistroIpat
     */
    public function setTon($ton)
    {
        $this->ton = $ton;

        return $this;
    }

    /**
     * Get ton
     *
     * @return string
     */
    public function getTon()
    {
        return $this->ton;
    }

    /**
     * Set pasajeros
     *
     * @param string $pasajeros
     *
     * @return SvRegistroIpat
     */
    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;

        return $this;
    }

    /**
     * Get pasajeros
     *
     * @return string
     */
    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return SvRegistroIpat
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set nitEmpresa
     *
     * @param string $nitEmpresa
     *
     * @return SvRegistroIpat
     */
    public function setNitEmpresa($nitEmpresa)
    {
        $this->nitEmpresa = $nitEmpresa;

        return $this;
    }

    /**
     * Get nitEmpresa
     *
     * @return string
     */
    public function getNitEmpresa()
    {
        return $this->nitEmpresa;
    }

    /**
     * Set matriculadoEn
     *
     * @param string $matriculadoEn
     *
     * @return SvRegistroIpat
     */
    public function setMatriculadoEn($matriculadoEn)
    {
        $this->matriculadoEn = $matriculadoEn;

        return $this;
    }

    /**
     * Get matriculadoEn
     *
     * @return string
     */
    public function getMatriculadoEn()
    {
        return $this->matriculadoEn;
    }

    /**
     * Set inmovilizadoEn
     *
     * @param string $inmovilizadoEn
     *
     * @return SvRegistroIpat
     */
    public function setInmovilizadoEn($inmovilizadoEn)
    {
        $this->inmovilizadoEn = $inmovilizadoEn;

        return $this;
    }

    /**
     * Get inmovilizadoEn
     *
     * @return string
     */
    public function getInmovilizadoEn()
    {
        return $this->inmovilizadoEn;
    }

    /**
     * Set aDisposicionDe
     *
     * @param string $aDisposicionDe
     *
     * @return SvRegistroIpat
     */
    public function setADisposicionDe($aDisposicionDe)
    {
        $this->aDisposicionDe = $aDisposicionDe;

        return $this;
    }

    /**
     * Get aDisposicionDe
     *
     * @return string
     */
    public function getADisposicionDe()
    {
        return $this->aDisposicionDe;
    }

    /**
     * Set tarjetaRegistro
     *
     * @param string $tarjetaRegistro
     *
     * @return SvRegistroIpat
     */
    public function setTarjetaRegistro($tarjetaRegistro)
    {
        $this->tarjetaRegistro = $tarjetaRegistro;

        return $this;
    }

    /**
     * Get tarjetaRegistro
     *
     * @return string
     */
    public function getTarjetaRegistro()
    {
        return $this->tarjetaRegistro;
    }

    /**
     * Set revisionTecnoMecanica
     *
     * @param string $revisionTecnoMecanica
     *
     * @return SvRegistroIpat
     */
    public function setRevisionTecnoMecanica($revisionTecnoMecanica)
    {
        $this->revisionTecnoMecanica = $revisionTecnoMecanica;

        return $this;
    }

    /**
     * Get revisionTecnoMecanica
     *
     * @return string
     */
    public function getRevisionTecnoMecanica()
    {
        return $this->revisionTecnoMecanica;
    }

    /**
     * Set numeroTecnoMecanica
     *
     * @param string $numeroTecnoMecanica
     *
     * @return SvRegistroIpat
     */
    public function setNumeroTecnoMecanica($numeroTecnoMecanica)
    {
        $this->numeroTecnoMecanica = $numeroTecnoMecanica;

        return $this;
    }

    /**
     * Get numeroTecnoMecanica
     *
     * @return string
     */
    public function getNumeroTecnoMecanica()
    {
        return $this->numeroTecnoMecanica;
    }

    /**
     * Set cantidadAcompaniantes
     *
     * @param string $cantidadAcompaniantes
     *
     * @return SvRegistroIpat
     */
    public function setCantidadAcompaniantes($cantidadAcompaniantes)
    {
        $this->cantidadAcompaniantes = $cantidadAcompaniantes;

        return $this;
    }

    /**
     * Get cantidadAcompaniantes
     *
     * @return string
     */
    public function getCantidadAcompaniantes()
    {
        return $this->cantidadAcompaniantes;
    }

    /**
     * Set portaSoat
     *
     * @param string $portaSoat
     *
     * @return SvRegistroIpat
     */
    public function setPortaSoat($portaSoat)
    {
        $this->portaSoat = $portaSoat;

        return $this;
    }

    /**
     * Get portaSoat
     *
     * @return string
     */
    public function getPortaSoat()
    {
        return $this->portaSoat;
    }

    /**
     * Set soat
     *
     * @param integer $soat
     *
     * @return SvRegistroIpat
     */
    public function setSoat($soat)
    {
        $this->soat = $soat;

        return $this;
    }

    /**
     * Get soat
     *
     * @return integer
     */
    public function getSoat()
    {
        return $this->soat;
    }

    /**
     * Set numeroPoliza
     *
     * @param integer $numeroPoliza
     *
     * @return SvRegistroIpat
     */
    public function setNumeroPoliza($numeroPoliza)
    {
        $this->numeroPoliza = $numeroPoliza;

        return $this;
    }

    /**
     * Get numeroPoliza
     *
     * @return integer
     */
    public function getNumeroPoliza()
    {
        return $this->numeroPoliza;
    }

    /**
     * Set aseguradoraSoat
     *
     * @param string $aseguradoraSoat
     *
     * @return SvRegistroIpat
     */
    public function setAseguradoraSoat($aseguradoraSoat)
    {
        $this->aseguradoraSoat = $aseguradoraSoat;

        return $this;
    }

    /**
     * Get aseguradoraSoat
     *
     * @return string
     */
    public function getAseguradoraSoat()
    {
        return $this->aseguradoraSoat;
    }

    /**
     * Set fechaVencimientoSoat
     *
     * @param \DateTime $fechaVencimientoSoat
     *
     * @return SvRegistroIpat
     */
    public function setFechaVencimientoSoat($fechaVencimientoSoat)
    {
        $this->fechaVencimientoSoat = $fechaVencimientoSoat;

        return $this;
    }

    /**
     * Get fechaVencimientoSoat
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSoat()
    {
        return $this->fechaVencimientoSoat;
    }

    /**
     * Set portaSeguroResponsabilidadCivil
     *
     * @param boolean $portaSeguroResponsabilidadCivil
     *
     * @return SvRegistroIpat
     */
    public function setPortaSeguroResponsabilidadCivil($portaSeguroResponsabilidadCivil)
    {
        $this->portaSeguroResponsabilidadCivil = $portaSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get portaSeguroResponsabilidadCivil
     *
     * @return boolean
     */
    public function getPortaSeguroResponsabilidadCivil()
    {
        return $this->portaSeguroResponsabilidadCivil;
    }

    /**
     * Set numeroSeguroResponsabilidadCivil
     *
     * @param integer $numeroSeguroResponsabilidadCivil
     *
     * @return SvRegistroIpat
     */
    public function setNumeroSeguroResponsabilidadCivil($numeroSeguroResponsabilidadCivil)
    {
        $this->numeroSeguroResponsabilidadCivil = $numeroSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get numeroSeguroResponsabilidadCivil
     *
     * @return integer
     */
    public function getNumeroSeguroResponsabilidadCivil()
    {
        return $this->numeroSeguroResponsabilidadCivil;
    }

    /**
     * Set aseguradoraSeguroResponsabilidadCivil
     *
     * @param string $aseguradoraSeguroResponsabilidadCivil
     *
     * @return SvRegistroIpat
     */
    public function setAseguradoraSeguroResponsabilidadCivil($aseguradoraSeguroResponsabilidadCivil)
    {
        $this->aseguradoraSeguroResponsabilidadCivil = $aseguradoraSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get aseguradoraSeguroResponsabilidadCivil
     *
     * @return string
     */
    public function getAseguradoraSeguroResponsabilidadCivil()
    {
        return $this->aseguradoraSeguroResponsabilidadCivil;
    }

    /**
     * Set fechaVencimientoSeguroResponsabilidadCivil
     *
     * @param \DateTime $fechaVencimientoSeguroResponsabilidadCivil
     *
     * @return SvRegistroIpat
     */
    public function setFechaVencimientoSeguroResponsabilidadCivil($fechaVencimientoSeguroResponsabilidadCivil)
    {
        $this->fechaVencimientoSeguroResponsabilidadCivil = $fechaVencimientoSeguroResponsabilidadCivil;

        return $this;
    }

    /**
     * Get fechaVencimientoSeguroResponsabilidadCivil
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSeguroResponsabilidadCivil()
    {
        return $this->fechaVencimientoSeguroResponsabilidadCivil;
    }

    /**
     * Set portaSeguroExtracontractual
     *
     * @param boolean $portaSeguroExtracontractual
     *
     * @return SvRegistroIpat
     */
    public function setPortaSeguroExtracontractual($portaSeguroExtracontractual)
    {
        $this->portaSeguroExtracontractual = $portaSeguroExtracontractual;

        return $this;
    }

    /**
     * Get portaSeguroExtracontractual
     *
     * @return boolean
     */
    public function getPortaSeguroExtracontractual()
    {
        return $this->portaSeguroExtracontractual;
    }

    /**
     * Set numeroSeguroExtracontractual
     *
     * @param integer $numeroSeguroExtracontractual
     *
     * @return SvRegistroIpat
     */
    public function setNumeroSeguroExtracontractual($numeroSeguroExtracontractual)
    {
        $this->numeroSeguroExtracontractual = $numeroSeguroExtracontractual;

        return $this;
    }

    /**
     * Get numeroSeguroExtracontractual
     *
     * @return integer
     */
    public function getNumeroSeguroExtracontractual()
    {
        return $this->numeroSeguroExtracontractual;
    }

    /**
     * Set aseguradoraSeguroExtracontractual
     *
     * @param string $aseguradoraSeguroExtracontractual
     *
     * @return SvRegistroIpat
     */
    public function setAseguradoraSeguroExtracontractual($aseguradoraSeguroExtracontractual)
    {
        $this->aseguradoraSeguroExtracontractual = $aseguradoraSeguroExtracontractual;

        return $this;
    }

    /**
     * Get aseguradoraSeguroExtracontractual
     *
     * @return string
     */
    public function getAseguradoraSeguroExtracontractual()
    {
        return $this->aseguradoraSeguroExtracontractual;
    }

    /**
     * Set fechaVencimientoSeguroExtracontractual
     *
     * @param \DateTime $fechaVencimientoSeguroExtracontractual
     *
     * @return SvRegistroIpat
     */
    public function setFechaVencimientoSeguroExtracontractual($fechaVencimientoSeguroExtracontractual)
    {
        $this->fechaVencimientoSeguroExtracontractual = $fechaVencimientoSeguroExtracontractual;

        return $this;
    }

    /**
     * Get fechaVencimientoSeguroExtracontractual
     *
     * @return \DateTime
     */
    public function getFechaVencimientoSeguroExtracontractual()
    {
        return $this->fechaVencimientoSeguroExtracontractual;
    }

    /**
     * Set mismoConductor
     *
     * @param boolean $mismoConductor
     *
     * @return SvRegistroIpat
     */
    public function setMismoConductor($mismoConductor)
    {
        $this->mismoConductor = $mismoConductor;

        return $this;
    }

    /**
     * Get mismoConductor
     *
     * @return boolean
     */
    public function getMismoConductor()
    {
        return $this->mismoConductor;
    }

    /**
     * Set nombresPropietario
     *
     * @param string $nombresPropietario
     *
     * @return SvRegistroIpat
     */
    public function setNombresPropietario($nombresPropietario)
    {
        $this->nombresPropietario = $nombresPropietario;

        return $this;
    }

    /**
     * Get nombresPropietario
     *
     * @return string
     */
    public function getNombresPropietario()
    {
        return $this->nombresPropietario;
    }

    /**
     * Set apellidosPropietario
     *
     * @param string $apellidosPropietario
     *
     * @return SvRegistroIpat
     */
    public function setApellidosPropietario($apellidosPropietario)
    {
        $this->apellidosPropietario = $apellidosPropietario;

        return $this;
    }

    /**
     * Get apellidosPropietario
     *
     * @return string
     */
    public function getApellidosPropietario()
    {
        return $this->apellidosPropietario;
    }

    /**
     * Set tipoIdentificacionPropietario
     *
     * @param string $tipoIdentificacionPropietario
     *
     * @return SvRegistroIpat
     */
    public function setTipoIdentificacionPropietario($tipoIdentificacionPropietario)
    {
        $this->tipoIdentificacionPropietario = $tipoIdentificacionPropietario;

        return $this;
    }

    /**
     * Get tipoIdentificacionPropietario
     *
     * @return string
     */
    public function getTipoIdentificacionPropietario()
    {
        return $this->tipoIdentificacionPropietario;
    }

    /**
     * Set identificacionPropietario
     *
     * @param integer $identificacionPropietario
     *
     * @return SvRegistroIpat
     */
    public function setIdentificacionPropietario($identificacionPropietario)
    {
        $this->identificacionPropietario = $identificacionPropietario;

        return $this;
    }

    /**
     * Get identificacionPropietario
     *
     * @return integer
     */
    public function getIdentificacionPropietario()
    {
        return $this->identificacionPropietario;
    }

    /**
     * Set clase
     *
     * @param string $clase
     *
     * @return SvRegistroIpat
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set servicio
     *
     * @param string $servicio
     *
     * @return SvRegistroIpat
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return string
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set modalidadTransporte
     *
     * @param string $modalidadTransporte
     *
     * @return SvRegistroIpat
     */
    public function setModalidadTransporte($modalidadTransporte)
    {
        $this->modalidadTransporte = $modalidadTransporte;

        return $this;
    }

    /**
     * Get modalidadTransporte
     *
     * @return string
     */
    public function getModalidadTransporte()
    {
        return $this->modalidadTransporte;
    }

    /**
     * Set radioAccion
     *
     * @param string $radioAccion
     *
     * @return SvRegistroIpat
     */
    public function setRadioAccion($radioAccion)
    {
        $this->radioAccion = $radioAccion;

        return $this;
    }

    /**
     * Get radioAccion
     *
     * @return string
     */
    public function getRadioAccion()
    {
        return $this->radioAccion;
    }

    /**
     * Set descripcionDanios
     *
     * @param string $descripcionDanios
     *
     * @return SvRegistroIpat
     */
    public function setDescripcionDanios($descripcionDanios)
    {
        $this->descripcionDanios = $descripcionDanios;

        return $this;
    }

    /**
     * Get descripcionDanios
     *
     * @return string
     */
    public function getDescripcionDanios()
    {
        return $this->descripcionDanios;
    }

    /**
     * Set falla
     *
     * @param array $falla
     *
     * @return SvRegistroIpat
     */
    public function setFalla($falla)
    {
        $this->falla = $falla;

        return $this;
    }

    /**
     * Get falla
     *
     * @return array
     */
    public function getFalla()
    {
        return $this->falla;
    }

    /**
     * Set lugarImpacto
     *
     * @param array $lugarImpacto
     *
     * @return SvRegistroIpat
     */
    public function setLugarImpacto($lugarImpacto)
    {
        $this->lugarImpacto = $lugarImpacto;

        return $this;
    }

    /**
     * Get lugarImpacto
     *
     * @return array
     */
    public function getLugarImpacto()
    {
        return $this->lugarImpacto;
    }

    /**
     * Set nombresConductor
     *
     * @param string $nombresConductor
     *
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * Set descripcionLesionConductor
     *
     * @param string $descripcionLesionConductor
     *
     * @return SvRegistroIpat
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
     * Set victima
     *
     * @param boolean $victima
     *
     * @return SvRegistroIpat
     */
    public function setVictima($victima)
    {
        $this->victima = $victima;

        return $this;
    }

    /**
     * Get victima
     *
     * @return boolean
     */
    public function getVictima()
    {
        return $this->victima;
    }

    /**
     * Set nombresVictima
     *
     * @param string $nombresVictima
     *
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * Set plavaVehiculoVictima
     *
     * @param string $plavaVehiculoVictima
     *
     * @return SvRegistroIpat
     */
    public function setPlavaVehiculoVictima($plavaVehiculoVictima)
    {
        $this->plavaVehiculoVictima = $plavaVehiculoVictima;

        return $this;
    }

    /**
     * Get plavaVehiculoVictima
     *
     * @return string
     */
    public function getPlavaVehiculoVictima()
    {
        return $this->plavaVehiculoVictima;
    }

    /**
     * Set practicoExamenVictima
     *
     * @param boolean $practicoExamenVictima
     *
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return SvRegistroIpat
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
     * Set nombresTestigo
     *
     * @param string $nombresTestigo
     *
     * @return SvRegistroIpat
     */
    public function setNombresTestigo($nombresTestigo)
    {
        $this->nombresTestigo = $nombresTestigo;

        return $this;
    }

    /**
     * Get nombresTestigo
     *
     * @return string
     */
    public function getNombresTestigo()
    {
        return $this->nombresTestigo;
    }

    /**
     * Set apellidosTestigo
     *
     * @param string $apellidosTestigo
     *
     * @return SvRegistroIpat
     */
    public function setApellidosTestigo($apellidosTestigo)
    {
        $this->apellidosTestigo = $apellidosTestigo;

        return $this;
    }

    /**
     * Get apellidosTestigo
     *
     * @return string
     */
    public function getApellidosTestigo()
    {
        return $this->apellidosTestigo;
    }

    /**
     * Set tipoIdentificacionTestigo
     *
     * @param string $tipoIdentificacionTestigo
     *
     * @return SvRegistroIpat
     */
    public function setTipoIdentificacionTestigo($tipoIdentificacionTestigo)
    {
        $this->tipoIdentificacionTestigo = $tipoIdentificacionTestigo;

        return $this;
    }

    /**
     * Get tipoIdentificacionTestigo
     *
     * @return string
     */
    public function getTipoIdentificacionTestigo()
    {
        return $this->tipoIdentificacionTestigo;
    }

    /**
     * Set identificacionTestigo
     *
     * @param string $identificacionTestigo
     *
     * @return SvRegistroIpat
     */
    public function setIdentificacionTestigo($identificacionTestigo)
    {
        $this->identificacionTestigo = $identificacionTestigo;

        return $this;
    }

    /**
     * Get identificacionTestigo
     *
     * @return string
     */
    public function getIdentificacionTestigo()
    {
        return $this->identificacionTestigo;
    }

    /**
     * Set direccionResidenciaTestigo
     *
     * @param string $direccionResidenciaTestigo
     *
     * @return SvRegistroIpat
     */
    public function setDireccionResidenciaTestigo($direccionResidenciaTestigo)
    {
        $this->direccionResidenciaTestigo = $direccionResidenciaTestigo;

        return $this;
    }

    /**
     * Get direccionResidenciaTestigo
     *
     * @return string
     */
    public function getDireccionResidenciaTestigo()
    {
        return $this->direccionResidenciaTestigo;
    }

    /**
     * Set ciudadResidenciaTestigo
     *
     * @param string $ciudadResidenciaTestigo
     *
     * @return SvRegistroIpat
     */
    public function setCiudadResidenciaTestigo($ciudadResidenciaTestigo)
    {
        $this->ciudadResidenciaTestigo = $ciudadResidenciaTestigo;

        return $this;
    }

    /**
     * Get ciudadResidenciaTestigo
     *
     * @return string
     */
    public function getCiudadResidenciaTestigo()
    {
        return $this->ciudadResidenciaTestigo;
    }

    /**
     * Set telefonoTestigo
     *
     * @param string $telefonoTestigo
     *
     * @return SvRegistroIpat
     */
    public function setTelefonoTestigo($telefonoTestigo)
    {
        $this->telefonoTestigo = $telefonoTestigo;

        return $this;
    }

    /**
     * Get telefonoTestigo
     *
     * @return string
     */
    public function getTelefonoTestigo()
    {
        return $this->telefonoTestigo;
    }

    /**
     * Set gradoAgente
     *
     * @param string $gradoAgente
     *
     * @return SvRegistroIpat
     */
    public function setGradoAgente($gradoAgente)
    {
        $this->gradoAgente = $gradoAgente;

        return $this;
    }

    /**
     * Get gradoAgente
     *
     * @return string
     */
    public function getGradoAgente()
    {
        return $this->gradoAgente;
    }

    /**
     * Set nombresAgente
     *
     * @param string $nombresAgente
     *
     * @return SvRegistroIpat
     */
    public function setNombresAgente($nombresAgente)
    {
        $this->nombresAgente = $nombresAgente;

        return $this;
    }

    /**
     * Get nombresAgente
     *
     * @return string
     */
    public function getNombresAgente()
    {
        return $this->nombresAgente;
    }

    /**
     * Set apellidosAgente
     *
     * @param string $apellidosAgente
     *
     * @return SvRegistroIpat
     */
    public function setApellidosAgente($apellidosAgente)
    {
        $this->apellidosAgente = $apellidosAgente;

        return $this;
    }

    /**
     * Get apellidosAgente
     *
     * @return string
     */
    public function getApellidosAgente()
    {
        return $this->apellidosAgente;
    }

    /**
     * Set tipoIdentificacionAgente
     *
     * @param string $tipoIdentificacionAgente
     *
     * @return SvRegistroIpat
     */
    public function setTipoIdentificacionAgente($tipoIdentificacionAgente)
    {
        $this->tipoIdentificacionAgente = $tipoIdentificacionAgente;

        return $this;
    }

    /**
     * Get tipoIdentificacionAgente
     *
     * @return string
     */
    public function getTipoIdentificacionAgente()
    {
        return $this->tipoIdentificacionAgente;
    }

    /**
     * Set identificacionAgente
     *
     * @param string $identificacionAgente
     *
     * @return SvRegistroIpat
     */
    public function setIdentificacionAgente($identificacionAgente)
    {
        $this->identificacionAgente = $identificacionAgente;

        return $this;
    }

    /**
     * Get identificacionAgente
     *
     * @return string
     */
    public function getIdentificacionAgente()
    {
        return $this->identificacionAgente;
    }

    /**
     * Set placaAgente
     *
     * @param string $placaAgente
     *
     * @return SvRegistroIpat
     */
    public function setPlacaAgente($placaAgente)
    {
        $this->placaAgente = $placaAgente;

        return $this;
    }

    /**
     * Get placaAgente
     *
     * @return string
     */
    public function getPlacaAgente()
    {
        return $this->placaAgente;
    }

    /**
     * Set entidadAgente
     *
     * @param string $entidadAgente
     *
     * @return SvRegistroIpat
     */
    public function setEntidadAgente($entidadAgente)
    {
        $this->entidadAgente = $entidadAgente;

        return $this;
    }

    /**
     * Get entidadAgente
     *
     * @return string
     */
    public function getEntidadAgente()
    {
        return $this->entidadAgente;
    }

    /**
     * Set totalPeaton
     *
     * @param string $totalPeaton
     *
     * @return SvRegistroIpat
     */
    public function setTotalPeaton($totalPeaton)
    {
        $this->totalPeaton = $totalPeaton;

        return $this;
    }

    /**
     * Get totalPeaton
     *
     * @return string
     */
    public function getTotalPeaton()
    {
        return $this->totalPeaton;
    }

    /**
     * Set totalAcompaniante
     *
     * @param string $totalAcompaniante
     *
     * @return SvRegistroIpat
     */
    public function setTotalAcompaniante($totalAcompaniante)
    {
        $this->totalAcompaniante = $totalAcompaniante;

        return $this;
    }

    /**
     * Get totalAcompaniante
     *
     * @return string
     */
    public function getTotalAcompaniante()
    {
        return $this->totalAcompaniante;
    }

    /**
     * Set totalPasajero
     *
     * @param string $totalPasajero
     *
     * @return SvRegistroIpat
     */
    public function setTotalPasajero($totalPasajero)
    {
        $this->totalPasajero = $totalPasajero;

        return $this;
    }

    /**
     * Get totalPasajero
     *
     * @return string
     */
    public function getTotalPasajero()
    {
        return $this->totalPasajero;
    }

    /**
     * Set totalConductor
     *
     * @param string $totalConductor
     *
     * @return SvRegistroIpat
     */
    public function setTotalConductor($totalConductor)
    {
        $this->totalConductor = $totalConductor;

        return $this;
    }

    /**
     * Get totalConductor
     *
     * @return string
     */
    public function getTotalConductor()
    {
        return $this->totalConductor;
    }

    /**
     * Set totalHerido
     *
     * @param string $totalHerido
     *
     * @return SvRegistroIpat
     */
    public function setTotalHerido($totalHerido)
    {
        $this->totalHerido = $totalHerido;

        return $this;
    }

    /**
     * Get totalHerido
     *
     * @return string
     */
    public function getTotalHerido()
    {
        return $this->totalHerido;
    }

    /**
     * Set totalMuerto
     *
     * @param string $totalMuerto
     *
     * @return SvRegistroIpat
     */
    public function setTotalMuerto($totalMuerto)
    {
        $this->totalMuerto = $totalMuerto;

        return $this;
    }

    /**
     * Get totalMuerto
     *
     * @return string
     */
    public function getTotalMuerto()
    {
        return $this->totalMuerto;
    }

    /**
     * Set anioCorrespondio
     *
     * @param integer $anioCorrespondio
     *
     * @return SvRegistroIpat
     */
    public function setAnioCorrespondio($anioCorrespondio)
    {
        $this->anioCorrespondio = $anioCorrespondio;

        return $this;
    }

    /**
     * Get anioCorrespondio
     *
     * @return integer
     */
    public function getAnioCorrespondio()
    {
        return $this->anioCorrespondio;
    }

    /**
     * Set consecutivoCorrespondio
     *
     * @param integer $consecutivoCorrespondio
     *
     * @return SvRegistroIpat
     */
    public function setConsecutivoCorrespondio($consecutivoCorrespondio)
    {
        $this->consecutivoCorrespondio = $consecutivoCorrespondio;

        return $this;
    }

    /**
     * Get consecutivoCorrespondio
     *
     * @return integer
     */
    public function getConsecutivoCorrespondio()
    {
        return $this->consecutivoCorrespondio;
    }

    /**
     * Set correspondio
     *
     * @param string $correspondio
     *
     * @return SvRegistroIpat
     */
    public function setCorrespondio($correspondio)
    {
        $this->correspondio = $correspondio;

        return $this;
    }

    /**
     * Get correspondio
     *
     * @return string
     */
    public function getCorrespondio()
    {
        return $this->correspondio;
    }

    /**
     * Set conductores
     *
     * @param array $conductores
     *
     * @return SvRegistroIpat
     */
    public function setConductores($conductores)
    {
        $this->conductores = $conductores;

        return $this;
    }

    /**
     * Get conductores
     *
     * @return array
     */
    public function getConductores()
    {
        return $this->conductores;
    }

    /**
     * Set vehiculos
     *
     * @param array $vehiculos
     *
     * @return SvRegistroIpat
     */
    public function setVehiculos($vehiculos)
    {
        $this->vehiculos = $vehiculos;

        return $this;
    }

    /**
     * Get vehiculos
     *
     * @return array
     */
    public function getVehiculos()
    {
        return $this->vehiculos;
    }

    /**
     * Set victimas
     *
     * @param array $victimas
     *
     * @return SvRegistroIpat
     */
    public function setVictimas($victimas)
    {
        $this->victimas = $victimas;

        return $this;
    }

    /**
     * Get victimas
     *
     * @return array
     */
    public function getVictimas()
    {
        return $this->victimas;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvRegistroIpat
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
     * Set consecutivo
     *
     * @param \AppBundle\Entity\MsvTConsecutivo $consecutivo
     *
     * @return SvRegistroIpat
     */
    public function setConsecutivo(\AppBundle\Entity\MsvTConsecutivo $consecutivo = null)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return \AppBundle\Entity\MsvTConsecutivo
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set sedeOperativa
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $sedeOperativa
     *
     * @return SvRegistroIpat
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
     * Set gravedad
     *
     * @param \AppBundle\Entity\CfgGravedad $gravedad
     *
     * @return SvRegistroIpat
     */
    public function setGravedad(\AppBundle\Entity\CfgGravedad $gravedad = null)
    {
        $this->gravedad = $gravedad;

        return $this;
    }

    /**
     * Get gravedad
     *
     * @return \AppBundle\Entity\CfgGravedad
     */
    public function getGravedad()
    {
        return $this->gravedad;
    }

    /**
     * Set claseAccidente
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente
     *
     * @return SvRegistroIpat
     */
    public function setClaseAccidente(\JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente $claseAccidente = null)
    {
        $this->claseAccidente = $claseAccidente;

        return $this;
    }

    /**
     * Get claseAccidente
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgClaseAccidente
     */
    public function getClaseAccidente()
    {
        return $this->claseAccidente;
    }

    /**
     * Set choqueCon
     *
     * @param \AppBundle\Entity\CfgChoqueCon $choqueCon
     *
     * @return SvRegistroIpat
     */
    public function setChoqueCon(\AppBundle\Entity\CfgChoqueCon $choqueCon = null)
    {
        $this->choqueCon = $choqueCon;

        return $this;
    }

    /**
     * Get choqueCon
     *
     * @return \AppBundle\Entity\CfgChoqueCon
     */
    public function getChoqueCon()
    {
        return $this->choqueCon;
    }

    /**
     * Set objetoFijo
     *
     * @param \AppBundle\Entity\CfgObjetoFijo $objetoFijo
     *
     * @return SvRegistroIpat
     */
    public function setObjetoFijo(\AppBundle\Entity\CfgObjetoFijo $objetoFijo = null)
    {
        $this->objetoFijo = $objetoFijo;

        return $this;
    }

    /**
     * Get objetoFijo
     *
     * @return \AppBundle\Entity\CfgObjetoFijo
     */
    public function getObjetoFijo()
    {
        return $this->objetoFijo;
    }

    /**
     * Set area
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgArea $area
     *
     * @return SvRegistroIpat
     */
    public function setArea(\JHWEB\SeguridadVialBundle\Entity\SvCfgArea $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgArea
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set sector
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSector $sector
     *
     * @return SvRegistroIpat
     */
    public function setSector(\JHWEB\SeguridadVialBundle\Entity\SvCfgSector $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set zona
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgZona $zona
     *
     * @return SvRegistroIpat
     */
    public function setZona(\JHWEB\SeguridadVialBundle\Entity\SvCfgZona $zona = null)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgZona
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set disenio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio $disenio
     *
     * @return SvRegistroIpat
     */
    public function setDisenio(\JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio $disenio = null)
    {
        $this->disenio = $disenio;

        return $this;
    }

    /**
     * Get disenio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgDisenio
     */
    public function getDisenio()
    {
        return $this->disenio;
    }

    /**
     * Set geometria
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria $geometria
     *
     * @return SvRegistroIpat
     */
    public function setGeometria(\JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria $geometria = null)
    {
        $this->geometria = $geometria;

        return $this;
    }

    /**
     * Get geometria
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgGeometria
     */
    public function getGeometria()
    {
        return $this->geometria;
    }

    /**
     * Set utilizacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion $utilizacion
     *
     * @return SvRegistroIpat
     */
    public function setUtilizacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion $utilizacion = null)
    {
        $this->utilizacion = $utilizacion;

        return $this;
    }

    /**
     * Get utilizacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgUtilizacion
     */
    public function getUtilizacion()
    {
        return $this->utilizacion;
    }

    /**
     * Set calzada
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $calzada
     *
     * @return SvRegistroIpat
     */
    public function setCalzada(\JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $calzada = null)
    {
        $this->calzada = $calzada;

        return $this;
    }

    /**
     * Get calzada
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril
     */
    public function getCalzada()
    {
        return $this->calzada;
    }

    /**
     * Set carril
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $carril
     *
     * @return SvRegistroIpat
     */
    public function setCarril(\JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril $carril = null)
    {
        $this->carril = $carril;

        return $this;
    }

    /**
     * Get carril
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCalzadaCarril
     */
    public function getCarril()
    {
        return $this->carril;
    }

    /**
     * Set material
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial $material
     *
     * @return SvRegistroIpat
     */
    public function setMaterial(\JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial $material = null)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgMaterial
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set estadoVia
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia $estadoVia
     *
     * @return SvRegistroIpat
     */
    public function setEstadoVia(\JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia $estadoVia = null)
    {
        $this->estadoVia = $estadoVia;

        return $this;
    }

    /**
     * Get estadoVia
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoVia
     */
    public function getEstadoVia()
    {
        return $this->estadoVia;
    }

    /**
     * Set condicionVia
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia $condicionVia
     *
     * @return SvRegistroIpat
     */
    public function setCondicionVia(\JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia $condicionVia = null)
    {
        $this->condicionVia = $condicionVia;

        return $this;
    }

    /**
     * Get condicionVia
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgCondicionVia
     */
    public function getCondicionVia()
    {
        return $this->condicionVia;
    }

    /**
     * Set iluminacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion $iluminacion
     *
     * @return SvRegistroIpat
     */
    public function setIluminacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion $iluminacion = null)
    {
        $this->iluminacion = $iluminacion;

        return $this;
    }

    /**
     * Get iluminacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgIluminacion
     */
    public function getIluminacion()
    {
        return $this->iluminacion;
    }

    /**
     * Set estadoIluminacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion $estadoIluminacion
     *
     * @return SvRegistroIpat
     */
    public function setEstadoIluminacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion $estadoIluminacion = null)
    {
        $this->estadoIluminacion = $estadoIluminacion;

        return $this;
    }

    /**
     * Get estadoIluminacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEstadoIluminacion
     */
    public function getEstadoIluminacion()
    {
        return $this->estadoIluminacion;
    }

    /**
     * Set visual
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgVisual $visual
     *
     * @return SvRegistroIpat
     */
    public function setVisual(\JHWEB\SeguridadVialBundle\Entity\SvCfgVisual $visual = null)
    {
        $this->visual = $visual;

        return $this;
    }

    /**
     * Get visual
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgVisual
     */
    public function getVisual()
    {
        return $this->visual;
    }

    /**
     * Set visualDisminuida
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida $visualDisminuida
     *
     * @return SvRegistroIpat
     */
    public function setVisualDisminuida(\JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida $visualDisminuida = null)
    {
        $this->visualDisminuida = $visualDisminuida;

        return $this;
    }

    /**
     * Get visualDisminuida
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgVisualDisminuida
     */
    public function getVisualDisminuida()
    {
        return $this->visualDisminuida;
    }

    /**
     * Set estadoSemaforo
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $estadoSemaforo
     *
     * @return SvRegistroIpat
     */
    public function setEstadoSemaforo(\JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $estadoSemaforo = null)
    {
        $this->estadoSemaforo = $estadoSemaforo;

        return $this;
    }

    /**
     * Get estadoSemaforo
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia
     */
    public function getEstadoSemaforo()
    {
        return $this->estadoSemaforo;
    }

    /**
     * Set delineadorPiso
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $delineadorPiso
     *
     * @return SvRegistroIpat
     */
    public function setDelineadorPiso(\JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia $delineadorPiso = null)
    {
        $this->delineadorPiso = $delineadorPiso;

        return $this;
    }

    /**
     * Get delineadorPiso
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgControlVia
     */
    public function getDelineadorPiso()
    {
        return $this->delineadorPiso;
    }

    /**
     * Set gravedadConductor
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgGravedadVictima $gravedadConductor
     *
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * Set hospitalVictima
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHospital $hospitalVictima
     *
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * @return SvRegistroIpat
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
     * Set hipotesis
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis $hipotesis
     *
     * @return SvRegistroIpat
     */
    public function setHipotesis(\JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis $hipotesis = null)
    {
        $this->hipotesis = $hipotesis;

        return $this;
    }

    /**
     * Get hipotesis
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgHipotesis
     */
    public function getHipotesis()
    {
        return $this->hipotesis;
    }

    /**
     * Set municipioCorrespondio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioCorrespondio
     *
     * @return SvRegistroIpat
     */
    public function setMunicipioCorrespondio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipioCorrespondio = null)
    {
        $this->municipioCorrespondio = $municipioCorrespondio;

        return $this;
    }

    /**
     * Get municipioCorrespondio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipioCorrespondio()
    {
        return $this->municipioCorrespondio;
    }

    /**
     * Set entidadCorrespondio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadCorrespondio
     *
     * @return SvRegistroIpat
     */
    public function setEntidadCorrespondio(\JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente $entidadCorrespondio = null)
    {
        $this->entidadCorrespondio = $entidadCorrespondio;

        return $this;
    }

    /**
     * Get entidadCorrespondio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEntidadAccidente
     */
    public function getEntidadCorrespondio()
    {
        return $this->entidadCorrespondio;
    }

    /**
     * Set unidadCorrespondio
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora $unidadCorrespondio
     *
     * @return SvRegistroIpat
     */
    public function setUnidadCorrespondio(\JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora $unidadCorrespondio = null)
    {
        $this->unidadCorrespondio = $unidadCorrespondio;

        return $this;
    }

    /**
     * Get unidadCorrespondio
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora
     */
    public function getUnidadCorrespondio()
    {
        return $this->unidadCorrespondio;
    }
}
