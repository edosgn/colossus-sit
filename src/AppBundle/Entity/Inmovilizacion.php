<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inmovilizacion
 *
 * @ORM\Table(name="inmovilizacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InmovilizacionRepository")
 */
class Inmovilizacion
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
     * @ORM\Column(name="numero", type="string", length=45)
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="comparendos")
     **/
    protected $comparendo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MparqGrua", inversedBy="inmovilizaciones")
     **/
    protected $grua;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MparqPatio", inversedBy="inmovilizaciones")
     **/
    protected $patio;

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
     * Set numero
     *
     * @param string $numero
     *
     * @return Inmovilizacion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return Inmovilizacion
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Inmovilizacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set comparendo
     *
     * @param \AppBundle\Entity\Comparendo $comparendo
     *
     * @return Inmovilizacion
     */
    public function setComparendo(\AppBundle\Entity\Comparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \AppBundle\Entity\Comparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set grua
     *
     * @param \AppBundle\Entity\MparqGrua $grua
     *
     * @return Inmovilizacion
     */
    public function setGrua(\AppBundle\Entity\MparqGrua $grua = null)
    {
        $this->grua = $grua;

        return $this;
    }

    /**
     * Get grua
     *
     * @return \AppBundle\Entity\MparqGrua
     */
    public function getGrua()
    {
        return $this->grua;
    }

    /**
     * Set patio
     *
     * @param \AppBundle\Entity\MparqPatio $patio
     *
     * @return Inmovilizacion
     */
    public function setPatio(\AppBundle\Entity\MparqPatio $patio = null)
    {
        $this->patio = $patio;

        return $this;
    }

    /**
     * Get patio
     *
     * @return \AppBundle\Entity\MparqPatio
     */
    public function getPatio()
    {
        return $this->patio;
    }
}
