<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDocumento
 *
 * @ORM\Table(name="tipo_documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoDocumentoRepository")
 */
class TipoDocumento
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
     * @ORM\Column(name="nombreTipo", type="string", length=45)
     */
    private $nombreTipo;

    /**
     * @var int
     *
     * @ORM\Column(name="diasDuracionTramite", type="integer")
     */
    private $diasDuracionTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoDocumento", type="string", length=45)
     */
    private $codigoDocumento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


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
     * Set nombreTipo
     *
     * @param string $nombreTipo
     *
     * @return TipoDocumento
     */
    public function setNombreTipo($nombreTipo)
    {
        $this->nombreTipo = $nombreTipo;

        return $this;
    }

    /**
     * Get nombreTipo
     *
     * @return string
     */
    public function getNombreTipo()
    {
        return $this->nombreTipo;
    }

    /**
     * Set diasDuracionTramite
     *
     * @param integer $diasDuracionTramite
     *
     * @return TipoDocumento
     */
    public function setDiasDuracionTramite($diasDuracionTramite)
    {
        $this->diasDuracionTramite = $diasDuracionTramite;

        return $this;
    }

    /**
     * Get diasDuracionTramite
     *
     * @return int
     */
    public function getDiasDuracionTramite()
    {
        return $this->diasDuracionTramite;
    }

    /**
     * Set codigoDocumento
     *
     * @param string $codigoDocumento
     *
     * @return TipoDocumento
     */
    public function setCodigoDocumento($codigoDocumento)
    {
        $this->codigoDocumento = $codigoDocumento;

        return $this;
    }

    /**
     * Get codigoDocumento
     *
     * @return string
     */
    public function getCodigoDocumento()
    {
        return $this->codigoDocumento;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TipoDocumento
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
