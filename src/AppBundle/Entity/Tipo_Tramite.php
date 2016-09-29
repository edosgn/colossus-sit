<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo_Tramite
 *
 * @ORM\Table(name="tipo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tipo_TramiteRepository")
 */
class Tipo_Tramite
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
     * @ORM\Column(name="nombreTramite", type="string", length=255)
     */
    private $nombreTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="smldv", type="string", length=255)
     */
    private $smldv;

    /**
     * @var int
     *
     * @ORM\Column(name="redondeo", type="integer")
     */
    private $redondeo;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="afectacion", type="string", length=255)
     */
    private $afectacion;


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
     * Set nombreTramite
     *
     * @param string $nombreTramite
     *
     * @return Tipo_Tramite
     */
    public function setNombreTramite($nombreTramite)
    {
        $this->nombreTramite = $nombreTramite;

        return $this;
    }

    /**
     * Get nombreTramite
     *
     * @return string
     */
    public function getNombreTramite()
    {
        return $this->nombreTramite;
    }

    /**
     * Set smldv
     *
     * @param string $smldv
     *
     * @return Tipo_Tramite
     */
    public function setSmldv($smldv)
    {
        $this->smldv = $smldv;

        return $this;
    }

    /**
     * Get smldv
     *
     * @return string
     */
    public function getSmldv()
    {
        return $this->smldv;
    }

    /**
     * Set redondeo
     *
     * @param integer $redondeo
     *
     * @return Tipo_Tramite
     */
    public function setRedondeo($redondeo)
    {
        $this->redondeo = $redondeo;

        return $this;
    }

    /**
     * Get redondeo
     *
     * @return int
     */
    public function getRedondeo()
    {
        return $this->redondeo;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     *
     * @return Tipo_Tramite
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set afectacion
     *
     * @param string $afectacion
     *
     * @return Tipo_Tramite
     */
    public function setAfectacion($afectacion)
    {
        $this->afectacion = $afectacion;

        return $this;
    }

    /**
     * Get afectacion
     *
     * @return string
     */
    public function getAfectacion()
    {
        return $this->afectacion;
    }
}

