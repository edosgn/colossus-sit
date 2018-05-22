<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramitePrecio
 *
 * @ORM\Table(name="tramite_precio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramitePrecioRepository")
 */
class TramitePrecio
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
     * @ORM\Column(name="valor", type="string", length=255, nullable = true)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=255)
     */
    private $anio;


    /**
     * @var string
     *
     * @ORM\Column(name="smldv", type="string", length=255)
     */
    private $smldv;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_estampilla", type="string", length=255)
     */
    private $valorEstampilla;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;



    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="vehiculos") */
    private $tramite;

     /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoVehiculo", inversedBy="vehiculos") */
     private $tipoVehiculo;



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
     * Set valor
     *
     * @param string $valor
     *
     * @return TramitePrecio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return TramitePrecio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set smldv
     *
     * @param string $smldv
     *
     * @return TramitePrecio
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
     * Set valorEstampilla
     *
     * @param string $valorEstampilla
     *
     * @return TramitePrecio
     */
    public function setValorEstampilla($valorEstampilla)
    {
        $this->valorEstampilla = $valorEstampilla;

        return $this;
    }

    /**
     * Get valorEstampilla
     *
     * @return string
     */
    public function getValorEstampilla()
    {
        return $this->valorEstampilla;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramitePrecio
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
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return TramitePrecio
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set tipoVehiculo
     *
     * @param \AppBundle\Entity\TipoVehiculo $tipoVehiculo
     *
     * @return TramitePrecio
     */
    public function setTipoVehiculo(\AppBundle\Entity\TipoVehiculo $tipoVehiculo = null)
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }

    /**
     * Get tipoVehiculo
     *
     * @return \AppBundle\Entity\TipoVehiculo
     */
    public function getTipoVehiculo()
    {
        return $this->tipoVehiculo;
    }
}
