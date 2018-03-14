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
     * @ORM\Column(name="diasDuraccionTramite", type="integer")
     */
    private $diasDuraccionTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoDocumento", type="string", length=45)
     */
    private $codigoDocumento;


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
     * Set diasDuraccionTramite
     *
     * @param integer $diasDuraccionTramite
     *
     * @return TipoDocumento
     */
    public function setDiasDuraccionTramite($diasDuraccionTramite)
    {
        $this->diasDuraccionTramite = $diasDuraccionTramite;

        return $this;
    }

    /**
     * Get diasDuraccionTramite
     *
     * @return int
     */
    public function getDiasDuraccionTramite()
    {
        return $this->diasDuraccionTramite;
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
}