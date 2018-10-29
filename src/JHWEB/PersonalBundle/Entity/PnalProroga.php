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

    /**
     * @var string
     *
     * @ORM\Column(name="numeroModificatorio", type="string", length=255)
     */
    private $numeroModificatorio;

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
        return $this->fechaInicio->format('Y-m-d');
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
        return $this->fechaFin->format('Y-m-d');
    }

    /**
     * Set numeroModificatorio
     *
     * @param string $numeroModificatorio
     *
     * @return PnalProroga
     */
    public function setNumeroModificatorio($numeroModificatorio)
    {
        $this->numeroModificatorio = $numeroModificatorio;

        return $this;
    }

    /**
     * Get numeroModificatorio
     *
     * @return string
     */
    public function getNumeroModificatorio()
    {
        return $this->numeroModificatorio;
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
