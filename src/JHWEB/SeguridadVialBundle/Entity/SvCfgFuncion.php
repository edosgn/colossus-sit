<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvCfgFuncion
 *
 * @ORM\Table(name="sv_cfg_funcion")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvCfgFuncionRepository")
 */
class SvCfgFuncion
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
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgEducacion", inversedBy="educacion")
     */
    private $educacion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgPreventiva", inversedBy="preventiva")
     */
    private $preventiva;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgPoliciaJudicial", inversedBy="policia_judicial")
     */
    private $policiaJudicial;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgAsistenciaCivica", inversedBy="asistencia_civica")
     */
    private $asistenciaCivica;
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgSolidaridad", inversedBy="solidaridad")
     */
    private $solidaridad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JHWEB\SeguridadVialBundle\Entity\SvCfgSeguridadCiudadana", inversedBy="seguridad_ciudadana")
     */
    private $seguridadCiudadana;

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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return SvCfgFuncion
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
     * Set educacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgEducacion $educacion
     *
     * @return SvCfgFuncion
     */
    public function setEducacion(\JHWEB\SeguridadVialBundle\Entity\SvCfgEducacion $educacion = null)
    {
        $this->educacion = $educacion;

        return $this;
    }

    /**
     * Get educacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgEducacion
     */
    public function getEducacion()
    {
        return $this->educacion;
    }

    /**
     * Set preventiva
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgPreventiva $preventiva
     *
     * @return SvCfgFuncion
     */
    public function setPreventiva(\JHWEB\SeguridadVialBundle\Entity\SvCfgPreventiva $preventiva = null)
    {
        $this->preventiva = $preventiva;

        return $this;
    }

    /**
     * Get preventiva
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgPreventiva
     */
    public function getPreventiva()
    {
        return $this->preventiva;
    }

    /**
     * Set policiaJudicial
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgPoliciaJudicial $policiaJudicial
     *
     * @return SvCfgFuncion
     */
    public function setPoliciaJudicial(\JHWEB\SeguridadVialBundle\Entity\SvCfgPoliciaJudicial $policiaJudicial = null)
    {
        $this->policiaJudicial = $policiaJudicial;

        return $this;
    }

    /**
     * Get policiaJudicial
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgPoliciaJudicial
     */
    public function getPoliciaJudicial()
    {
        return $this->policiaJudicial;
    }

    /**
     * Set asistenciaCivica
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgAsistenciaCivica $asistenciaCivica
     *
     * @return SvCfgFuncion
     */
    public function setAsistenciaCivica(\JHWEB\SeguridadVialBundle\Entity\SvCfgAsistenciaCivica $asistenciaCivica = null)
    {
        $this->asistenciaCivica = $asistenciaCivica;

        return $this;
    }

    /**
     * Get asistenciaCivica
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgAsistenciaCivica
     */
    public function getAsistenciaCivica()
    {
        return $this->asistenciaCivica;
    }

    /**
     * Set solidaridad
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSolidaridad $solidaridad
     *
     * @return SvCfgFuncion
     */
    public function setSolidaridad(\JHWEB\SeguridadVialBundle\Entity\SvCfgSolidaridad $solidaridad = null)
    {
        $this->solidaridad = $solidaridad;

        return $this;
    }

    /**
     * Get solidaridad
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSolidaridad
     */
    public function getSolidaridad()
    {
        return $this->solidaridad;
    }

    /**
     * Set seguridadCiudadana
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvCfgSeguridadCiudadana $seguridadCiudadana
     *
     * @return SvCfgFuncion
     */
    public function setSeguridadCiudadana(\JHWEB\SeguridadVialBundle\Entity\SvCfgSeguridadCiudadana $seguridadCiudadana = null)
    {
        $this->seguridadCiudadana = $seguridadCiudadana;

        return $this;
    }

    /**
     * Get seguridadCiudadana
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvCfgSeguridadCiudadana
     */
    public function getSeguridadCiudadana()
    {
        return $this->seguridadCiudadana;
    }
}
