<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvTalonario
 *
 * @ORM\Table(name="msv_talonario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvTalonarioRepository")
 */
class MsvTalonario
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="msvTalonarios")
     **/
    protected $sedeOperativa;

    /**
     * @var int
     *
     * @ORM\Column(name="rangoini", type="integer")
     */
    private $rangoini;

    /**
     * @var int
     *
     * @ORM\Column(name="rangofin", type="integer")
     */
    private $rangofin;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAsignacion", type="date")
     */
    private $fechaAsignacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nResolucion", type="string", length=255)
     */
    private $nResolucion;



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
     * Set rangoini
     *
     * @param integer $rangoini
     *
     * @return MsvTalonario
     */
    public function setrangoini($rangoini)
    {
        $this->rangoini = $rangoini;

        return $this;
    }

    /**
     * Get rangoini
     *
     * @return integer
     */
    public function getrangoini()
    {
        return $this->rangoini;
    }

    /**
     * Set rangofin
     *
     * @param integer $rangofin
     *
     * @return MsvTalonario
     */
    public function setrangofin($rangofin)
    {
        $this->rangofin = $rangofin;

        return $this;
    }

    /**
     * Get rangofin
     *
     * @return integer
     */
    public function getrangofin()
    {
        return $this->rangofin;
    }

    /**
     * Set total
     *
     * @param integer $total
     *
     * @return MsvTalonario
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return MsvTalonario
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion->format("Y-m-d");
    }

    /**
     * Set nResolucion
     *
     * @param string $nResolucion
     *
     * @return MsvTalonario
     */
    public function setNResolucion($nResolucion)
    {
        $this->nResolucion = $nResolucion;

        return $this;
    }

    /**
     * Get nResolucion
     *
     * @return string
     */
    public function getNResolucion()
    {
        return $this->nResolucion;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return MsvTalonario
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
