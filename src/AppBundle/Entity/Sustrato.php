<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sustrato
 *
 * @ORM\Table(name="sustrato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SustratoRepository")
 */
class Sustrato
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
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="desde", type="string", length=10)
     */
    private $desde;

    /**
     * @var string
     *
     * @ORM\Column(name="hasta", type="string", length=10)
     */
    private $hasta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="sustratos")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="sustratos")
     **/
    protected $modulo;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return Sustrato
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set desde
     *
     * @param string $desde
     *
     * @return Sustrato
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return string
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param string $hasta
     *
     * @return Sustrato
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return string
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return Sustrato
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

    /**
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return Sustrato
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
