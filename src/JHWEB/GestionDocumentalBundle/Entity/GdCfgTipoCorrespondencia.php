<?php

namespace JHWEB\GestionDocumentalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GdCfgTipoCorrespondencia
 *
 * @ORM\Table(name="gd_cfg_tipo_correspondencia")
 * @ORM\Entity(repositoryClass="JHWEB\GestionDocumentalBundle\Repository\GdCfgTipoCorrespondenciaRepository")
 */
class GdCfgTipoCorrespondencia
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="dias_vigencia", type="integer")
     */
    private $diasVigencia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="editable", type="boolean")
     */
    private $editable = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="prohibicion", type="boolean")
     */
    private $prohibicion = false;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return GdCfgTipoCorrespondencia
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
     * Set diasVigencia
     *
     * @param integer $diasVigencia
     *
     * @return GdCfgTipoCorrespondencia
     */
    public function setDiasVigencia($diasVigencia)
    {
        $this->diasVigencia = $diasVigencia;

        return $this;
    }

    /**
     * Get diasVigencia
     *
     * @return integer
     */
    public function getDiasVigencia()
    {
        return $this->diasVigencia;
    }

    /**
     * Set editable
     *
     * @param boolean $editable
     *
     * @return GdCfgTipoCorrespondencia
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * Get editable
     *
     * @return boolean
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     * Set prohibicion
     *
     * @param boolean $prohibicion
     *
     * @return GdCfgTipoCorrespondencia
     */
    public function setProhibicion($prohibicion)
    {
        $this->prohibicion = $prohibicion;

        return $this;
    }

    /**
     * Get prohibicion
     *
     * @return boolean
     */
    public function getProhibicion()
    {
        return $this->prohibicion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return GdCfgTipoCorrespondencia
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
}
