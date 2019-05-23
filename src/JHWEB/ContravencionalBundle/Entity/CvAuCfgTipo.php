<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvAuCfgTipo
 *
 * @ORM\Table(name="cv_au_cfg_tipo")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvAuCfgTipoRepository")
 */
class CvAuCfgTipo
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgAdmFormato", inversedBy="actosAdministrativos") */
    private $formato;


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
     * @return CvAuCfgTipo
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvAuCfgTipo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set formato
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgAdmFormato $formato
     *
     * @return CvAuCfgTipo
     */
    public function setFormato(\JHWEB\ConfigBundle\Entity\CfgAdmFormato $formato = null)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgAdmFormato
     */
    public function getFormato()
    {
        return $this->formato;
    }
}
