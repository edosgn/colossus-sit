<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpersonalAsignacion
 *
 * @ORM\Table(name="mpersonal_asignacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MpersonalAsignacionRepository")
 */
class MpersonalAsignacion
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
     * @ORM\Column(name="fechaAsignacion", type="date")
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
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="asignaciones")
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
     * @return MpersonalAsignacion
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return int
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
     * @return MpersonalAsignacion
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return int
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
     * @return MpersonalAsignacion
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
     * @return MpersonalAsignacion
     */
    public function setRangos($rangos)
    {
        $this->rangos = $rangos;

        return $this;
    }

    /**
     * Get rangos
     *
     * @return int
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
     * @return MpersonalAsignacion
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
     * Set funcionario
     *
     * @param \AppBundle\Entity\MpersonalFuncionario $funcionario
     *
     * @return MpersonalAsignacion
     */
    public function setFuncionario(\AppBundle\Entity\MpersonalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \AppBundle\Entity\MpersonalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
