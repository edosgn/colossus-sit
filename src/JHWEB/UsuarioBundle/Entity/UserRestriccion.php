<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRestriccion
 *
 * @ORM\Table(name="user_restriccion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserRestriccionRepository")
 */
class UserRestriccion
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\Column(name="foranea", type="integer", nullable=true)
     */
    private $foranea;

    /**
     * @var int
     *
     * @ORM\Column(name="tabla", type="integer", nullable=true)
     */
    private $tabla;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date", nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="UserCiudadano", inversedBy="limitaciones")
     **/
    protected $usuario;

    

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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UserRestriccion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set foranea
     *
     * @param integer $foranea
     *
     * @return UserRestriccion
     */
    public function setForanea($foranea)
    {
        $this->foranea = $foranea;

        return $this;
    }

    /**
     * Get foranea
     *
     * @return integer
     */
    public function getForanea()
    {
        return $this->foranea;
    }

    /**
     * Set tabla
     *
     * @param integer $tabla
     *
     * @return UserRestriccion
     */
    public function setTabla($tabla)
    {
        $this->tabla = $tabla;

        return $this;
    }

    /**
     * Get tabla
     *
     * @return integer
     */
    public function getTabla()
    {
        return $this->tabla;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return UserRestriccion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return UserRestriccion
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return UserRestriccion
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserRestriccion
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
     * Set usuario
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $usuario
     *
     * @return UserRestriccion
     */
    public function setUsuario(\JHWEB\UsuarioBundle\Entity\UserCiudadano $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
