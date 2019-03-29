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
     * @ORM\Column(name="numero_modificatorio", type="string", length=255)
     */
    private $numeroModificatorio;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="prorogas") */
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
     * @return PnalProroga
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
        if ($this->fechaInicial) {
            return $this->fechaInicial->format('d/m/Y');
        }
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return PnalProroga
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
            return $this->fechaFinal->format('d/m/Y');
        }
        return $this->fechaFinal;
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
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return PnalProroga
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
