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
}
