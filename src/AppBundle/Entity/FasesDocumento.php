<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FasesDocumento
 *
 * @ORM\Table(name="fases_documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FasesDocumentoRepository")
 */
class FasesDocumento
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
     * @var string
     *
     * @ORM\Column(name="nombreFase", type="string", length=45)
     */
    private $nombreFase;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinFase", type="date")
     */
    private $fechaFinFase;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicioFase", type="date")
     */
    private $fechaInicioFase;

    /**
     * @var string
     *
     * @ORM\Column(name="actuacionFase", type="text")
     */
    private $actuacionFase;

    /**
     * @var string
     *
     * @ORM\Column(name="urlDocumentoGenerado", type="string", length=145)
     */
    private $urlDocumentoGenerado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="fasesDocumentos")
     **/
    protected $funcionarioResponzable;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RegistroDocumento", inversedBy="fasesDocumentos")
     **/
    protected $registroDocumento;


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
     * Set nombreFase
     *
     * @param string $nombreFase
     *
     * @return FasesDocumento
     */
    public function setNombreFase($nombreFase)
    {
        $this->nombreFase = $nombreFase;

        return $this;
    }

    /**
     * Get nombreFase
     *
     * @return string
     */
    public function getNombreFase()
    {
        return $this->nombreFase;
    }

    /**
     * Set fechaFinFase
     *
     * @param \DateTime $fechaFinFase
     *
     * @return FasesDocumento
     */
    public function setFechaFinFase($fechaFinFase)
    {
        $this->fechaFinFase = $fechaFinFase;

        return $this;
    }

    /**
     * Get fechaFinFase
     *
     * @return \DateTime
     */
    public function getFechaFinFase()
    {
        return $this->fechaFinFase;
    }

    /**
     * Set fechaInicioFase
     *
     * @param \DateTime $fechaInicioFase
     *
     * @return FasesDocumento
     */
    public function setFechaInicioFase($fechaInicioFase)
    {
        $this->fechaInicioFase = $fechaInicioFase;

        return $this;
    }

    /**
     * Get fechaInicioFase
     *
     * @return \DateTime
     */
    public function getFechaInicioFase()
    {
        return $this->fechaInicioFase;
    }

    /**
     * Set actuacionFase
     *
     * @param string $actuacionFase
     *
     * @return FasesDocumento
     */
    public function setActuacionFase($actuacionFase)
    {
        $this->actuacionFase = $actuacionFase;

        return $this;
    }

    /**
     * Get actuacionFase
     *
     * @return string
     */
    public function getActuacionFase()
    {
        return $this->actuacionFase;
    }

    /**
     * Set urlDocumentoGenerado
     *
     * @param string $urlDocumentoGenerado
     *
     * @return FasesDocumento
     */
    public function setUrlDocumentoGenerado($urlDocumentoGenerado)
    {
        $this->urlDocumentoGenerado = $urlDocumentoGenerado;

        return $this;
    }

    /**
     * Get urlDocumentoGenerado
     *
     * @return string
     */
    public function getUrlDocumentoGenerado()
    {
        return $this->urlDocumentoGenerado;
    }

    /**
     * Set funcionarioResponzable
     *
     * @param \AppBundle\Entity\Ciudadano $funcionarioResponzable
     *
     * @return FasesDocumento
     */
    public function setFuncionarioResponzable(\AppBundle\Entity\Ciudadano $funcionarioResponzable = null)
    {
        $this->funcionarioResponzable = $funcionarioResponzable;

        return $this;
    }

    /**
     * Get funcionarioResponzable
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getFuncionarioResponzable()
    {
        return $this->funcionarioResponzable;
    }

    /**
     * Set registroDocumento
     *
     * @param \AppBundle\Entity\RegistroDocumento $registroDocumento
     *
     * @return FasesDocumento
     */
    public function setRegistroDocumento(\AppBundle\Entity\RegistroDocumento $registroDocumento = null)
    {
        $this->registroDocumento = $registroDocumento;

        return $this;
    }

    /**
     * Get registroDocumento
     *
     * @return \AppBundle\Entity\RegistroDocumento
     */
    public function getRegistroDocumento()
    {
        return $this->registroDocumento;
    }
}
