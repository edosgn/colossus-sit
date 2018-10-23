<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalProroga
 *
 * @ORM\Table(name="pnal_proroga")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalProrogaRepository")
 */
class PnalProroga
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
     * @return PnalProroga
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
        if ($this->fechaInicio) {
            return $this->fechaInicio->format('Y-m-d');
        }
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return PnalProroga
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
        if ($this->fechaFin) {
            return $this->fechaFin->format('Y-m-d');
        }

        return $this->fechaFin;
        
    }

    /**
     * Set mPersonalFuncionario
     *
     * @param \AppBundle\Entity\MpersonalFuncionario $mPersonalFuncionario
     *
     * @return PnalProroga
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
