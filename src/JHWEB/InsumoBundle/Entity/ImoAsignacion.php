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

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Insumo", inversedBy="soats") */
    private $insumo;

    /** @ORM\ManyToOne(targetEntity="ImoTrazabilidad", inversedBy="soats") */
    private $imoTrazabilidad;
    

    

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
     * @param \AppBundle\Entity\Insumo $insumo
     *
     * @return ImoAsignacion
     */
    public function setInsumo(\AppBundle\Entity\Insumo $insumo = null)
    {
        $this->insumo = $insumo;

        return $this;
    }

    /**
     * Get insumo
     *
     * @return \AppBundle\Entity\Insumo
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
}
