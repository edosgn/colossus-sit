<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MgdTipoCorrespondencia
 *
 * @ORM\Table(name="mgd_tipo_correspondencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MgdTipoCorrespondenciaRepository")
 */
class MgdTipoCorrespondencia
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
     * @ORM\Column(name="diasVigencia", type="integer")
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
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

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
     * @return MgdTipoCorrespondencia
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
     * @return MgdTipoCorrespondencia
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
     * @return MgdTipoCorrespondencia
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
     * @return MgdTipoCorrespondencia
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return MgdTipoCorrespondencia
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
}
