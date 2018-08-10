<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistorialPrecio
 *
 * @ORM\Table(name="historial_precio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HistorialPrecioRepository")
 */
class HistorialPrecio
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
     * @var int
     *
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="historialPrecios")
     **/
    protected $tramite;


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
     * Set anio
     *
     * @param integer $anio
     *
     * @return HistorialPrecio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return int
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return HistorialPrecio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return HistorialPrecio
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
     * @return HistorialPrecio
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
}
