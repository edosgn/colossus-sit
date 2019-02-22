<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCiudadano
 *
 * @ORM\Table(name="user_ciudadano")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserCiudadanoRepository")
 */
class UserCiudadano
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
     * @ORM\Column(name="primer_nombre", type="string", length=255)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=255, nullable=true)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=255)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=255, nullable=true)
     */
    private $segundoApellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="identificacion", type="integer", nullable=false)
     */
    private $identificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion_documento", type="datetime", nullable=true)
     */
    private $fechaExpedicionDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_personal", type="string", length=255)
     */
    private $direccionPersonal;

     /**
     * @var string
     *
     * @ORM\Column(name="direccion_trabajo", type="string", length=255, nullable=true)
     */
    private $direccionTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enrolado", type="boolean", nullable=true)
     */
    private $enrolado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="ciudadanos") */
    private $municipioNacimiento;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="ciudadanos") */
    private $municipioResidencia;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGenero", inversedBy="ciudadanos") */
    private $genero;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo", inversedBy="ciudadanos") */
    private $grupoSanguineo;

    /** @ORM\ManyToOne(targetEntity="UserCfgTipoIdentificacion", inversedBy="ciudadanos") */
    private $tipoIdentificacion;

    /**
     * @ORM\OneToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario")
     */
    private $usuario;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

