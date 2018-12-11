<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalSuspension
 *
 * @ORM\Table(name="pnal_suspension")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalSuspensionRepository")
 */
class PnalSuspension
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date")
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="soats") */
    private $mPersonalFuncionario;



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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return PnalSuspension
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio->format('Y-m-d');
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return PnalSuspension
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin->format('Y-m-d');
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return PnalSuspension
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set mPersonalFuncionario
     *
     * @param \AppBundle\Entity\MpersonalFuncionario $mPersonalFuncionario
     *
     * @return PnalSuspension
     */
    public function setMPersonalFuncionario(\AppBundle\Entity\MpersonalFuncionario $mPersonalFuncionario = null)
    {
        $this->mPersonalFuncionario = $mPersonalFuncionario;

        return $this;
    }

    /**
     * Get mPersonalFuncionario
     *
     * @return \AppBundle\Entity\MpersonalFuncionario
     */
    public function getMPersonalFuncionario()
    {
        return $this->mPersonalFuncionario;
    }
}
