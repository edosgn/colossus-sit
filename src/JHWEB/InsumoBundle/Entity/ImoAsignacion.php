<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoAsignacion
 *
 * @ORM\Table(name="imo_asignacion")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoAsignacionRepository")
 */
class ImoAsignacion
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

    /** @ORM\ManyToOne(targetEntity="ImoInsumo", inversedBy="asignaciones") */
    private $insumo;

    /** @ORM\ManyToOne(targetEntity="ImoTrazabilidad", inversedBy="asignaciones") */
    private $imoTrazabilidad;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario")
     **/
    protected $funcionario;

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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return ImoAsignacion
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
     * Set insumo
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoInsumo $insumo
     *
     * @return ImoAsignacion
     */
    public function setInsumo(\JHWEB\InsumoBundle\Entity\ImoInsumo $insumo = null)
    {
        $this->insumo = $insumo;

        return $this;
    }

    /**
     * Get insumo
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoInsumo
     */
    public function getInsumo()
    {
        return $this->insumo;
    }

    /**
     * Set imoTrazabilidad
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoTrazabilidad $imoTrazabilidad
     *
     * @return ImoAsignacion
     */
    public function setImoTrazabilidad(\JHWEB\InsumoBundle\Entity\ImoTrazabilidad $imoTrazabilidad = null)
    {
        $this->imoTrazabilidad = $imoTrazabilidad;

        return $this;
    }

    /**
     * Get imoTrazabilidad
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoTrazabilidad
     */
    public function getImoTrazabilidad()
    {
        return $this->imoTrazabilidad;
    }

    /**
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return ImoAsignacion
     */
    public function setFuncionario(\JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
