<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * TramiteTraslado
 *
 * @ORM\Table(name="tramite_traslado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteTrasladoRepository")
 */
class TramiteTraslado
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
     * @ORM\Column(name="fechaSalida", type="date")
     */
    private $fechaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGuia", type="string", length=50)
     */
    private $numeroGuia;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEmpresa", type="string", length=255)
     */
    private $nombreEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroRunt", type="string", length=255)
     */
    private $numeroRunt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa")
     **/
    protected $sedeOperativa;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    

   

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
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return TramiteTraslado
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set numeroGuia
     *
     * @param string $numeroGuia
     *
     * @return TramiteTraslado
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
     * Set nombreEmpresa
     *
     * @param string $nombreEmpresa
     *
     * @return TramiteTraslado
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    /**
     * Get nombreEmpresa
     *
     * @return string
     */
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * Set numeroRunt
     *
     * @param string $numeroRunt
     *
     * @return TramiteTraslado
     */
    public function setNumeroRunt($numeroRunt)
    {
        $this->numeroRunt = $numeroRunt;

        return $this;
    }

    /**
     * Get numeroRunt
     *
     * @return string
     */
    public function getNumeroRunt()
    {
        return $this->numeroRunt;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteTraslado
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

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return TramiteTraslado
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }
}
