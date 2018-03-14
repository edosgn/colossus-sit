<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedidaCautelar
 *
 * @ORM\Table(name="medida_cautelar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedidaCautelarRepository")
 */
class MedidaCautelar
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
     * @ORM\Column(name="numeroOficio", type="string", length=45)
     */
    private $numeroOficio;

    /**
     * @var string
     *
     * @ORM\Column(name="quienOrdena", type="string", length=45)
     */
    private $quienOrdena;

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
     * @ORM\Column(name="identificacionImplicado", type="string", length=45)
     */
    private $identificacionImplicado;

    /**
     * @var string
     *
     * @ORM\Column(name="delito", type="string", length=45)
     */
    private $delito;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RegistroDocumento", inversedBy="medidasCautelares")
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
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return MedidaCautelar
     */
    public function setNumeroOficio($numeroOficio)
    {
        $this->numeroOficio = $numeroOficio;

        return $this;
    }

    /**
     * Get numeroOficio
     *
     * @return string
     */
    public function getNumeroOficio()
    {
        return $this->numeroOficio;
    }

    /**
     * Set quienOrdena
     *
     * @param string $quienOrdena
     *
     * @return MedidaCautelar
     */
    public function setQuienOrdena($quienOrdena)
    {
        $this->quienOrdena = $quienOrdena;

        return $this;
    }

    /**
     * Get quienOrdena
     *
     * @return string
     */
    public function getQuienOrdena()
    {
        return $this->quienOrdena;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return MedidaCautelar
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
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return MedidaCautelar
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
        return $this->fechaFin;
    }

    /**
     * Set identificacionImplicado
     *
     * @param string $identificacionImplicado
     *
     * @return MedidaCautelar
     */
    public function setIdentificacionImplicado($identificacionImplicado)
    {
        $this->identificacionImplicado = $identificacionImplicado;

        return $this;
    }

    /**
     * Get identificacionImplicado
     *
     * @return string
     */
    public function getIdentificacionImplicado()
    {
        return $this->identificacionImplicado;
    }

    /**
     * Set delito
     *
     * @param string $delito
     *
     * @return MedidaCautelar
     */
    public function setDelito($delito)
    {
        $this->delito = $delito;

        return $this;
    }

    /**
     * Get delito
     *
     * @return string
     */
    public function getDelito()
    {
        return $this->delito;
    }

    /**
     * Set registroDocumento
     *
     * @param \AppBundle\Entity\RegistroDocumento $registroDocumento
     *
     * @return MedidaCautelar
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
