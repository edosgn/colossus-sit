<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="integer")
     */
    private $telefono;

     /**
     * @var int
     *
     * @ORM\Column(name="celular", type="integer")
     */
    private $celular;

    /**
     * @var int
     *
     * @ORM\Column(name="fax", type="integer")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=255)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="capital_pagado", type="string", length=255)
     */
    private $capitalPagado;

    /**
     * @var string
     *
     * @ORM\Column(name="capital_liquido", type="string", length=255)
     */
    private $capitalLiquido;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_entidad", type="string", length=255)
     */
    private $tipoEntidad;

    /**
     * @var string
     *
     * @ORM\Column(name="certificado_existencia", type="string", length=255)
     */
    private $certificadoExistencia;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_registro_mercantil", type="string", length=255)
     */
    private $nroRegistroMercantil;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

     /**
     * @var boolean
     *
     * @ORM\Column(name="empresa_prestadora", type="boolean")
     */
    private $empresaPrestadora;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento_registro_mercantil", type="datetime")
     */
    private $fechaVencimientoRegistroMercantil;

    
    
    
    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="empresas") */
    private $municipio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoSociedad", inversedBy="empresas") */
    private $tipoSocidad;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="empresas") */
    private $ciudadano;

    


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
     * @return Empresa
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * @return Empresa
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
     * Set certificadoExistencia
     *
     * @param string $certificadoExistencia
     *
     * @return Empresa
     */
    public function setCertificadoExistencia($certificadoExistencia)
    {
        $this->certificadoExistencia = $certificadoExistencia;

        return $this;
    }

    /**
     * Get certificadoExistencia
     *
     * @return string
     */
    public function getCertificadoExistencia()
    {
        return $this->certificadoExistencia;
    }

    /**
     * Set nroRegistroMercantil
     *
     * @param string $nroRegistroMercantil
     *
     * @return Empresa
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Empresa
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set empresaPrestadora
     *
     * @param boolean $empresaPrestadora
     *
     * @return Empresa
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
     * @return Empresa
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
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Empresa
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set tipoSocidad
     *
     * @param \AppBundle\Entity\TipoSociedad $tipoSocidad
     *
     * @return Empresa
     */
    public function setTipoSocidad(\AppBundle\Entity\TipoSociedad $tipoSocidad = null)
    {
        $this->tipoSocidad = $tipoSocidad;

        return $this;
    }

    /**
     * Get tipoSocidad
     *
     * @return \AppBundle\Entity\TipoSociedad
     */
    public function getTipoSocidad()
    {
        return $this->tipoSocidad;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return Empresa
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
}
