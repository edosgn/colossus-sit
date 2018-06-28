<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MgdSeguimiento
 *
 * @ORM\Table(name="mgd_seguimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MgdSeguimientoRepository")
 */
class MgdSeguimiento
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
     * @ORM\Column(name="estado", type="string", length=50)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAsignacion", type="datetime")
     */
    private $fechaAsignacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRespuesta", type="datetime", nullable=true)
     */
    private $fechaRespuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=225, nullable=true)
     */
    private $url;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="Repository\UsuarioBundle\Entity\Usuario", inversedBy="seguimientos") */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MgdDocumento", inversedBy="seguimientos")
     **/
    protected $documento;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return MgdSeguimiento
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return MgdSeguimiento
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion;
    }

    /**
     * Set fechaRespuesta
     *
     * @param \DateTime $fechaRespuesta
     *
     * @return MgdSeguimiento
     */
    public function setFechaRespuesta($fechaRespuesta)
    {
        $this->fechaRespuesta = $fechaRespuesta;

        return $this;
    }

    /**
     * Get fechaRespuesta
     *
     * @return \DateTime
     */
    public function getFechaRespuesta()
    {
        return $this->fechaRespuesta;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return MgdSeguimiento
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MgdSeguimiento
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
     * Set responsable
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $responsable
     *
     * @return MgdSeguimiento
     */
    public function setResponsable(\Repository\UsuarioBundle\Entity\Usuario $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \Repository\UsuarioBundle\Entity\Usuario
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set documento
     *
     * @param \AppBundle\Entity\MgdDocumento $documento
     *
     * @return MgdSeguimiento
     */
    public function setDocumento(\AppBundle\Entity\MgdDocumento $documento = null)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \AppBundle\Entity\MgdDocumento
     */
    public function getDocumento()
    {
        return $this->documento;
    }
}
