<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEmpresa
 *
 * @ORM\Table(name="user_empresa")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserEmpresaRepository")
 */
class UserEmpresa
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
     * @ORM\Column(name="nit", type="integer")
     */
    private $nit;

    /**
     * @var int
     *
     * @ORM\Column(name="dv", type="integer")
     */
    private $dv;
 
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="bigint", nullable = true)
     */
    private $telefono;

     /**
     * @var int
     *
     * @ORM\Column(name="celular", type="bigint", nullable = true)
     */
    private $celular;

    /**
     * @var int
     *
     * @ORM\Column(name="fax", type="bigint", nullable = true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable = true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable = true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=255, nullable=true)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="capital_pagado", type="string", length=255, nullable=true)
     */
    private $capitalPagado;

    /**
     * @var string
     *
     * @ORM\Column(name="capital_liquido", type="string", length=255, nullable=true)
     */
    private $capitalLiquido;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_entidad", type="string", length=255, nullable=true)
     */
    private $tipoEntidad;

    /**
     * @var string
     *
     * @ORM\Column(name="certificado_existencial", type="string", length=255, nullable=true)
     */
    private $certificadoExistencial;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_registro_mercantil", type="string", length=255, nullable = true)
     */
    private $nroRegistroMercantil;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

     /**
     * @var boolean
     *
     * @ORM\Column(name="empresa_prestadora", type="boolean", nullable=true)
     */
    private $empresaPrestadora;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_registro_mercantil", type="datetime", nullable = true)
     */
    private $fechaVencimientoRegistroMercantil;
    
    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgMunicipio", inversedBy="empresas") */
    private $municipio;

    /** @ORM\ManyToOne(targetEntity="UserCiudadano", inversedBy="empresas") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="UserEmpresa", inversedBy="empresas") */
    private $empresa;

    /** @ORM\ManyToOne(targetEntity="UserCfgTipoIdentificacion", inversedBy="empresas") */
    private $tipoIdentificacion;

    /** @ORM\ManyToOne(targetEntity="UserCfgEmpresaServicio", inversedBy="empresas") */
    private $empresaServicio;

    /** @ORM\ManyToOne(targetEntity="UserCfgEmpresaTipo", inversedBy="empresas") */
    private $tipoEmpresa;

    /** @ORM\ManyToOne(targetEntity="UserCfgEmpresaTipoSociedad", inversedBy="empresas") */
    private $tipoSociedad;

    /** @ORM\ManyToOne(targetEntity="UserEmpresaRepresentante", inversedBy="empresas") */
    private $empresaRepresentante;

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
     * Set nit
     *
     * @param integer $nit
     *
     * @return UserEmpresa
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return integer
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set dv
     *
     * @param integer $dv
     *
     * @return UserEmpresa
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return integer
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return UserEmpresa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return UserEmpresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param integer $celular
     *
     * @return UserEmpresa
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return integer
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     *
     * @return UserEmpresa
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return integer
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return UserEmpresa
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return UserEmpresa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     *
     * @return UserEmpresa
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set capitalPagado
     *
     * @param string $capitalPagado
     *
     * @return UserEmpresa
     */
    public function setCapitalPagado($capitalPagado)
    {
        $this->capitalPagado = $capitalPagado;

        return $this;
    }

    /**
     * Get capitalPagado
     *
     * @return string
     */
    public function getCapitalPagado()
    {
        return $this->capitalPagado;
    }

    /**
     * Set capitalLiquido
     *
     * @param string $capitalLiquido
     *
     * @return UserEmpresa
     */
    public function setCapitalLiquido($capitalLiquido)
    {
        $this->capitalLiquido = $capitalLiquido;

        return $this;
    }

    /**
     * Get capitalLiquido
     *
     * @return string
     */
    public function getCapitalLiquido()
    {
        return $this->capitalLiquido;
    }

    /**
     * Set tipoEntidad
     *
     * @param string $tipoEntidad
     *
     * @return UserEmpresa
     */
    public function setTipoEntidad($tipoEntidad)
    {
        $this->tipoEntidad = $tipoEntidad;

        return $this;
    }

    /**
     * Get tipoEntidad
     *
     * @return string
     */
    public function getTipoEntidad()
    {
        return $this->tipoEntidad;
    }

    /**
     * Set certificadoExistencial
     *
     * @param string $certificadoExistencial
     *
     * @return UserEmpresa
     */
    public function setCertificadoExistencial($certificadoExistencial)
    {
        $this->certificadoExistencial = $certificadoExistencial;

        return $this;
    }

    /**
     * Get certificadoExistencial
     *
     * @return string
     */
    public function getCertificadoExistencial()
    {
        return $this->certificadoExistencial;
    }

    /**
     * Set nroRegistroMercantil
     *
     * @param string $nroRegistroMercantil
     *
     * @return UserEmpresa
     */
    public function setNroRegistroMercantil($nroRegistroMercantil)
    {
        $this->nroRegistroMercantil = $nroRegistroMercantil;

        return $this;
    }

    /**
     * Get nroRegistroMercantil
     *
     * @return string
     */
    public function getNroRegistroMercantil()
    {
        return $this->nroRegistroMercantil;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserEmpresa
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
     * Set empresaPrestadora
     *
     * @param boolean $empresaPrestadora
     *
     * @return UserEmpresa
     */
    public function setEmpresaPrestadora($empresaPrestadora)
    {
        $this->empresaPrestadora = $empresaPrestadora;

        return $this;
    }

    /**
     * Get empresaPrestadora
     *
     * @return boolean
     */
    public function getEmpresaPrestadora()
    {
        return $this->empresaPrestadora;
    }

    /**
     * Set fechaVencimientoRegistroMercantil
     *
     * @param \DateTime $fechaVencimientoRegistroMercantil
     *
     * @return UserEmpresa
     */
    public function setFechaVencimientoRegistroMercantil($fechaVencimientoRegistroMercantil)
    {
        $this->fechaVencimientoRegistroMercantil = $fechaVencimientoRegistroMercantil;

        return $this;
    }

    /**
     * Get fechaVencimientoRegistroMercantil
     *
     * @return \DateTime
     */
    public function getFechaVencimientoRegistroMercantil()
    {
        return $this->fechaVencimientoRegistroMercantil;
    }

    /**
     * Set municipio
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio
     *
     * @return UserEmpresa
     */
    public function setMunicipio(\JHWEB\ConfigBundle\Entity\CfgMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgMunicipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return UserEmpresa
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

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return UserEmpresa
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set tipoIdentificacion
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacion
     *
     * @return UserEmpresa
     */
    public function setTipoIdentificacion(\JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion $tipoIdentificacion = null)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgTipoIdentificacion
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
    }

    /**
     * Set empresaServicio
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaServicio $empresaServicio
     *
     * @return UserEmpresa
     */
    public function setEmpresaServicio(\JHWEB\UsuarioBundle\Entity\UserCfgEmpresaServicio $empresaServicio = null)
    {
        $this->empresaServicio = $empresaServicio;

        return $this;
    }

    /**
     * Get empresaServicio
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaServicio
     */
    public function getEmpresaServicio()
    {
        return $this->empresaServicio;
    }

    /**
     * Set tipoEmpresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipo $tipoEmpresa
     *
     * @return UserEmpresa
     */
    public function setTipoEmpresa(\JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipo $tipoEmpresa = null)
    {
        $this->tipoEmpresa = $tipoEmpresa;

        return $this;
    }

    /**
     * Get tipoEmpresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipo
     */
    public function getTipoEmpresa()
    {
        return $this->tipoEmpresa;
    }

    /**
     * Set tipoSociedad
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipoSociedad $tipoSociedad
     *
     * @return UserEmpresa
     */
    public function setTipoSociedad(\JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipoSociedad $tipoSociedad = null)
    {
        $this->tipoSociedad = $tipoSociedad;

        return $this;
    }

    /**
     * Get tipoSociedad
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipoSociedad
     */
    public function getTipoSociedad()
    {
        return $this->tipoSociedad;
    }

    /**
     * Set empresaRepresentante
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante $empresaRepresentante
     *
     * @return UserEmpresa
     */
    public function setEmpresaRepresentante(\JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante $empresaRepresentante = null)
    {
        $this->empresaRepresentante = $empresaRepresentante;

        return $this;
    }

    /**
     * Get empresaRepresentante
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante
     */
    public function getEmpresaRepresentante()
    {
        return $this->empresaRepresentante;
    }
}
