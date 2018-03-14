<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroDocumento
 *
 * @ORM\Table(name="registro_documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistroDocumentoRepository")
 */
class RegistroDocumento
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
     * @ORM\Column(name="codigoRadicado", type="string", length=45)
     */
    private $codigoRadicado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tiempoRadicacion", type="datetime")
     */
    private $tiempoRadicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="asuntoDocumento", type="text")
     */
    private $asuntoDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoDocumento", type="string", length=45)
     */
    private $estadoDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="urlDocumentoEscaneado", type="string", length=145)
     */
    private $urlDocumentoEscaneado;

    /**
     * @var int
     *
     * @ORM\Column(name="tiempoTranscurrido", type="integer")
     */
    private $tiempoTranscurrido;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroFolios", type="integer")
     */
    private $numeroFolios;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoDocumento", inversedBy="casos")
     **/
    protected $tipoDocumento;


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
     * Set codigoRadicado
     *
     * @param string $codigoRadicado
     *
     * @return RegistroDocumento
     */
    public function setCodigoRadicado($codigoRadicado)
    {
        $this->codigoRadicado = $codigoRadicado;

        return $this;
    }

    /**
     * Get codigoRadicado
     *
     * @return string
     */
    public function getCodigoRadicado()
    {
        return $this->codigoRadicado;
    }

    /**
     * Set tiempoRadicacion
     *
     * @param \DateTime $tiempoRadicacion
     *
     * @return RegistroDocumento
     */
    public function setTiempoRadicacion($tiempoRadicacion)
    {
        $this->tiempoRadicacion = $tiempoRadicacion;

        return $this;
    }

    /**
     * Get tiempoRadicacion
     *
     * @return \DateTime
     */
    public function getTiempoRadicacion()
    {
        return $this->tiempoRadicacion;
    }

    /**
     * Set asuntoDocumento
     *
     * @param string $asuntoDocumento
     *
     * @return RegistroDocumento
     */
    public function setAsuntoDocumento($asuntoDocumento)
    {
        $this->asuntoDocumento = $asuntoDocumento;

        return $this;
    }

    /**
     * Get asuntoDocumento
     *
     * @return string
     */
    public function getAsuntoDocumento()
    {
        return $this->asuntoDocumento;
    }

    /**
     * Set estadoDocumento
     *
     * @param string $estadoDocumento
     *
     * @return RegistroDocumento
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estadoDocumento = $estadoDocumento;

        return $this;
    }

    /**
     * Get estadoDocumento
     *
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estadoDocumento;
    }

    /**
     * Set urlDocumentoEscaneado
     *
     * @param string $urlDocumentoEscaneado
     *
     * @return RegistroDocumento
     */
    public function setUrlDocumentoEscaneado($urlDocumentoEscaneado)
    {
        $this->urlDocumentoEscaneado = $urlDocumentoEscaneado;

        return $this;
    }

    /**
     * Get urlDocumentoEscaneado
     *
     * @return string
     */
    public function getUrlDocumentoEscaneado()
    {
        return $this->urlDocumentoEscaneado;
    }

    /**
     * Set tiempoTranscurrido
     *
     * @param integer $tiempoTranscurrido
     *
     * @return RegistroDocumento
     */
    public function setTiempoTranscurrido($tiempoTranscurrido)
    {
        $this->tiempoTranscurrido = $tiempoTranscurrido;

        return $this;
    }

    /**
     * Get tiempoTranscurrido
     *
     * @return int
     */
    public function getTiempoTranscurrido()
    {
        return $this->tiempoTranscurrido;
    }

    /**
     * Set numeroFolios
     *
     * @param integer $numeroFolios
     *
     * @return RegistroDocumento
     */
    public function setNumeroFolios($numeroFolios)
    {
        $this->numeroFolios = $numeroFolios;

        return $this;
    }

    /**
     * Get numeroFolios
     *
     * @return int
     */
    public function getNumeroFolios()
    {
        return $this->numeroFolios;
    }

    /**
     * Set tipoDocumento
     *
     * @param \AppBundle\Entity\TipoDocumento $tipoDocumento
     *
     * @return RegistroDocumento
     */
    public function setTipoDocumento(\AppBundle\Entity\TipoDocumento $tipoDocumento = null)
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    /**
     * Get tipoDocumento
     *
     * @return \AppBundle\Entity\TipoDocumento
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }
}
