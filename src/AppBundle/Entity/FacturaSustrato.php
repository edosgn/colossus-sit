<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacturaSustrato
 *
 * @ORM\Table(name="factura_sustrato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacturaSustratoRepository")
 */
class FacturaSustrato
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
     * @ORM\Column(name="descripcion", type="string", length=1000)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="inmovilizaciones")
     **/
    protected $factura;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="inmovilizaciones")
     **/
    protected $ciudadano;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sustrato", inversedBy="inmovilizaciones")
     **/
    protected $sustrato;



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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return FacturaSustrato
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return FacturaSustrato
     */
    public function setFactura(\AppBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return FacturaSustrato
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set sustrato
     *
     * @param \AppBundle\Entity\Sustrato $sustrato
     *
     * @return FacturaSustrato
     */
    public function setSustrato(\AppBundle\Entity\Sustrato $sustrato = null)
    {
        $this->sustrato = $sustrato;

        return $this;
    }

    /**
     * Get sustrato
     *
     * @return \AppBundle\Entity\Sustrato
     */
    public function getSustrato()
    {
        return $this->sustrato;
    }
}
