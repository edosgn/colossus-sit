<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCfgReparto
 *
 * @ORM\Table(name="cv_cfg_reparto")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCfgRepartoRepository")
 */
class CvCfgReparto
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="CvCdoCfgEstado", inversedBy="repartos")
     **/
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="CvCfgModulo", inversedBy="repartos")
     **/
    protected $modulo;


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
     * @return CvCfgReparto
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
     * Set estado
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado
     *
     * @return CvCfgReparto
     */
    public function setEstado(\JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set modulo
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgModulo $modulo
     *
     * @return CvCfgReparto
     */
    public function setModulo(\JHWEB\ContravencionalBundle\Entity\CvCfgModulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgModulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
