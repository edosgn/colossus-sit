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
     * @ORM\Column(name="numeroPatio", type="string", length=45)
     */
    private $numeroPatio;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroGrua", type="string", length=45)
     */
    private $numeroGrua;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroConsecutivo", type="string", length=45)
     */
    private $numeroConsecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionPatio", type="string", length=45)
     */
    private $direccionPatio;

    /**
     * @var string
     *
     * @ORM\Column(name="placaGrua", type="string", length=45)
     */
    private $placaGrua;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="inmovilizaciones")
     **/
    protected $comparendo;


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
     * Set numeroPatio
     *
     * @param string $numeroPatio
     *
     * @return Inmovilizacion
     */
    public function setNumeroPatio($numeroPatio)
    {
        $this->numeroPatio = $numeroPatio;

        return $this;
    }

    /**
     * Get numeroPatio
     *
     * @return string
     */
    public function getNumeroPatio()
    {
        return $this->numeroPatio;
    }

    /**
     * Set numeroGrua
     *
     * @param string $numeroGrua
     *
     * @return Inmovilizacion
     */
    public function setNumeroGrua($numeroGrua)
    {
        $this->numeroGrua = $numeroGrua;

        return $this;
    }

    /**
     * Get numeroGrua
     *
     * @return string
     */
    public function getNumeroGrua()
    {
        return $this->numeroGrua;
    }

    /**
     * Set numeroConsecutivo
     *
     * @param string $numeroConsecutivo
     *
     * @return Inmovilizacion
     */
    public function setNumeroConsecutivo($numeroConsecutivo)
    {
        $this->numeroConsecutivo = $numeroConsecutivo;

        return $this;
    }

    /**
     * Get numeroConsecutivo
     *
     * @return string
     */
    public function getNumeroConsecutivo()
    {
        return $this->numeroConsecutivo;
    }

    /**
     * Set direccionPatio
     *
     * @param string $direccionPatio
     *
     * @return Inmovilizacion
     */
    public function setDireccionPatio($direccionPatio)
    {
        $this->direccionPatio = $direccionPatio;

        return $this;
    }

    /**
     * Get direccionPatio
     *
     * @return string
     */
    public function getDireccionPatio()
    {
        return $this->direccionPatio;
    }

    /**
     * Set placaGrua
     *
     * @param string $placaGrua
     *
     * @return Inmovilizacion
     */
    public function setPlacaGrua($placaGrua)
    {
        $this->placaGrua = $placaGrua;

        return $this;
    }

    /**
     * Get placaGrua
     *
     * @return string
     */
    public function getPlacaGrua()
    {
        return $this->placaGrua;
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
}
