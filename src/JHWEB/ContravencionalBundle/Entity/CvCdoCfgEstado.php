<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoCfgEstado
 *
 * @ORM\Table(name="cv_cdo_cfg_estado")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoCfgEstadoRepository")
 */
class CvCdoCfgEstado
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
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=3)
     */
    private $sigla;

    /**
     * @var bool
     *
     * @ORM\Column(name="simit", type="boolean")
     */
    private $simit;

    /**
     * @var int
     *
     * @ORM\Column(name="dias", type="integer", nullable=true)
     */
    private $dias;

    /**
     * @var bool
     *
     * @ORM\Column(name="habiles", type="boolean", nullable=true)
     */
    private $habiles;

    /**
     * @var bool
     *
     * @ORM\Column(name="actualiza", type="boolean")
     */
    private $actualiza;

    /**
     * @var bool
     *
     * @ORM\Column(name="finaliza", type="boolean")
     */
    private $finaliza;

    /**
     * @var bool
     *
     * @ORM\Column(name="reparto", type="boolean")
     */
    private $reparto;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgAdmFormato", inversedBy="estados")
     **/
    protected $formato;


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
     * @return CvCdoCfgEstado
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
     * Set sigla
     *
     * @param string $sigla
     *
     * @return CvCdoCfgEstado
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
     * Set simit
     *
     * @param boolean $simit
     *
     * @return CvCdoCfgEstado
     */
    public function setSimit($simit)
    {
        $this->simit = $simit;

        return $this;
    }

    /**
     * Get simit
     *
     * @return boolean
     */
    public function getSimit()
    {
        return $this->simit;
    }

    /**
     * Set dias
     *
     * @param integer $dias
     *
     * @return CvCdoCfgEstado
     */
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    /**
     * Get dias
     *
     * @return integer
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set habiles
     *
     * @param boolean $habiles
     *
     * @return CvCdoCfgEstado
     */
    public function setHabiles($habiles)
    {
        $this->habiles = $habiles;

        return $this;
    }

    /**
     * Get habiles
     *
     * @return boolean
     */
    public function getHabiles()
    {
        return $this->habiles;
    }

    /**
     * Set actualiza
     *
     * @param boolean $actualiza
     *
     * @return CvCdoCfgEstado
     */
    public function setActualiza($actualiza)
    {
        $this->actualiza = $actualiza;

        return $this;
    }

    /**
     * Get actualiza
     *
     * @return boolean
     */
    public function getActualiza()
    {
        return $this->actualiza;
    }

    /**
     * Set finaliza
     *
     * @param boolean $finaliza
     *
     * @return CvCdoCfgEstado
     */
    public function setFinaliza($finaliza)
    {
        $this->finaliza = $finaliza;

        return $this;
    }

    /**
     * Get finaliza
     *
     * @return boolean
     */
    public function getFinaliza()
    {
        return $this->finaliza;
    }

    /**
     * Set reparto
     *
     * @param boolean $reparto
     *
     * @return CvCdoCfgEstado
     */
    public function setReparto($reparto)
    {
        $this->reparto = $reparto;

        return $this;
    }

    /**
     * Get reparto
     *
     * @return boolean
     */
    public function getReparto()
    {
        return $this->reparto;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoCfgEstado
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
     * Set formato
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgAdmFormato $formato
     *
     * @return CvCdoCfgEstado
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
