<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Peticionario
 *
 * @ORM\Table(name="peticionario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeticionarioRepository")
 */
class Peticionario
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
     * @ORM\Column(name="nombrePeticionario", type="string", length=80)
     */
    private $nombrePeticionario;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacionPeticionario", type="string", length=15)
     */
    private $identificacionPeticionario;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionPeticionario", type="string", length=45)
     */
    private $direccionPeticionario;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoPeticionario", type="string", length=15)
     */
    private $telefonoPeticionario;

    /**
     * @var string
     *
     * @ORM\Column(name="correoElectronico", type="string", length=45)
     */
    private $correoElectronico;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroOficio", type="string", length=45)
     */
    private $numeroOficio;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoPeticionario", type="string", length=45)
     */
    private $tipoPeticionario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RegistroDocumento", inversedBy="peticionarios")
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
     * Set nombrePeticionario
     *
     * @param string $nombrePeticionario
     *
     * @return Peticionario
     */
    public function setNombrePeticionario($nombrePeticionario)
    {
        $this->nombrePeticionario = $nombrePeticionario;

        return $this;
    }

    /**
     * Get nombrePeticionario
     *
     * @return string
     */
    public function getNombrePeticionario()
    {
        return $this->nombrePeticionario;
    }

    /**
     * Set identificacionPeticionario
     *
     * @param string $identificacionPeticionario
     *
     * @return Peticionario
     */
    public function setIdentificacionPeticionario($identificacionPeticionario)
    {
        $this->identificacionPeticionario = $identificacionPeticionario;

        return $this;
    }

    /**
     * Get identificacionPeticionario
     *
     * @return string
     */
    public function getIdentificacionPeticionario()
    {
        return $this->identificacionPeticionario;
    }

    /**
     * Set direccionPeticionario
     *
     * @param string $direccionPeticionario
     *
     * @return Peticionario
     */
    public function setDireccionPeticionario($direccionPeticionario)
    {
        $this->direccionPeticionario = $direccionPeticionario;

        return $this;
    }

    /**
     * Get direccionPeticionario
     *
     * @return string
     */
    public function getDireccionPeticionario()
    {
        return $this->direccionPeticionario;
    }

    /**
     * Set telefonoPeticionario
     *
     * @param string $telefonoPeticionario
     *
     * @return Peticionario
     */
    public function setTelefonoPeticionario($telefonoPeticionario)
    {
        $this->telefonoPeticionario = $telefonoPeticionario;

        return $this;
    }

    /**
     * Get telefonoPeticionario
     *
     * @return string
     */
    public function getTelefonoPeticionario()
    {
        return $this->telefonoPeticionario;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Peticionario
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set numeroOficio
     *
     * @param string $numeroOficio
     *
     * @return Peticionario
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
     * Set tipoPeticionario
     *
     * @param string $tipoPeticionario
     *
     * @return Peticionario
     */
    public function setTipoPeticionario($tipoPeticionario)
    {
        $this->tipoPeticionario = $tipoPeticionario;

        return $this;
    }

    /**
     * Get tipoPeticionario
     *
     * @return string
     */
    public function getTipoPeticionario()
    {
        return $this->tipoPeticionario;
    }

    /**
     * Set registroDocumento
     *
     * @param \AppBundle\Entity\RegistroDocumento $registroDocumento
     *
     * @return Peticionario
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