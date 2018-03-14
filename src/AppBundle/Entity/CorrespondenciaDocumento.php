<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CorrespondenciaDocumento
 *
 * @ORM\Table(name="correspondencia_documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CorrespondenciaDocumentoRepository")
 */
class CorrespondenciaDocumento
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
     * @ORM\Column(name="tipoActuacion", type="string", length=45)
     */
    private $tipoActuacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEmpresaEnvio", type="string", length=45)
     */
    private $nombreEmpresaEnvio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEnvio", type="date")
     */
    private $fechaEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGuia", type="string", length=45)
     */
    private $numeroGuia;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RegistroDocumento", inversedBy="correspondenciasDocumentos")
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
     * Set tipoActuacion
     *
     * @param string $tipoActuacion
     *
     * @return CorrespondenciaDocumento
     */
    public function setTipoActuacion($tipoActuacion)
    {
        $this->tipoActuacion = $tipoActuacion;

        return $this;
    }

    /**
     * Get tipoActuacion
     *
     * @return string
     */
    public function getTipoActuacion()
    {
        return $this->tipoActuacion;
    }

    /**
     * Set nombreEmpresaEnvio
     *
     * @param string $nombreEmpresaEnvio
     *
     * @return CorrespondenciaDocumento
     */
    public function setNombreEmpresaEnvio($nombreEmpresaEnvio)
    {
        $this->nombreEmpresaEnvio = $nombreEmpresaEnvio;

        return $this;
    }

    /**
     * Get nombreEmpresaEnvio
     *
     * @return string
     */
    public function getNombreEmpresaEnvio()
    {
        return $this->nombreEmpresaEnvio;
    }

    /**
     * Set fechaEnvio
     *
     * @param \DateTime $fechaEnvio
     *
     * @return CorrespondenciaDocumento
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    /**
     * Get fechaEnvio
     *
     * @return \DateTime
     */
    public function getFechaEnvio()
    {
        return $this->fechaEnvio;
    }

    /**
     * Set numeroGuia
     *
     * @param string $numeroGuia
     *
     * @return CorrespondenciaDocumento
     */
    public function setNumeroGuia($numeroGuia)
    {
        $this->numeroGuia = $numeroGuia;

        return $this;
    }

    /**
     * Get numeroGuia
     *
     * @return string
     */
    public function getNumeroGuia()
    {
        return $this->numeroGuia;
    }

    /**
     * Set registroDocumento
     *
     * @param \AppBundle\Entity\RegistroDocumento $registroDocumento
     *
     * @return CorrespondenciaDocumento
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
