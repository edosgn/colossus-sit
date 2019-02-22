<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalAsignacion
 *
 * @ORM\Table(name="pnal_asignacion")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalAsignacionRepository")
 */
class PnalAsignacion
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
     * @var int
     *
     * @ORM\Column(name="desde", type="bigint")
     */
    private $desde;

    /**
     * @var int
     *
     * @ORM\Column(name="hasta", type="bigint")
     */
    private $hasta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_asignacion", type="date")
     */
    private $fechaAsignacion;

    /**
     * @var int
     *
     * @ORM\Column(name="rangos", type="integer")
     */
    private $rangos;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="asignaciones")
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
     * Set desde
     *
     * @param integer $desde
     *
     * @return PnalAsignacion
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return integer
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param integer $hasta
     *
     * @return PnalAsignacion
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return integer
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return PnalAsignacion
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion;
    }

    /**
     * Set rangos
     *
     * @param integer $rangos
     *
     * @return PnalAsignacion
     */
    public function setRangos($rangos)
    {
        $this->rangos = $rangos;

        return $this;
    }

    /**
     * Get rangos
     *
     * @return integer
     */
    public function getRangos()
    {
        return $this->rangos;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalAsignacion
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
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return PnalAsignacion
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
