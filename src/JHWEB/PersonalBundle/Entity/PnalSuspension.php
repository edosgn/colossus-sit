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
     * @ORM\Column(name="fecha_inicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date")
     */
    private $fechaFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="suspensiones") */
    private $funcionario;

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
     * Set fechaInicial
     *
     * @param \DateTime $fechaInicial
     *
     * @return PnalSuspension
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        if ($this->fechaFinal) {
            return $this->fechaFinal->format('Y-m-d');
        }
        return $this->fechaFinal;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return PnalSuspension
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        if ($this->fechaFinal) {
            return $this->fechaFinal->format('Y-m-d');
        }
        return $this->fechaFinal;
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
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return PnalSuspension
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
