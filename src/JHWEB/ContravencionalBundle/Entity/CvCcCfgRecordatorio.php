<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCcCfgRecordatorio
 *
 * @ORM\Table(name="cv_cc_cfg_recordatorio")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCcCfgRecordatorioRepository")
 */
class CvCcCfgRecordatorio
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
     * @ORM\ManyToOne(targetEntity="CvCdoCfgEstado", inversedBy="recordatorios")
     **/
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="facturas")
     **/
    protected $funcionario;


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
     * @return CvCcCfgRecordatorio
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
}

