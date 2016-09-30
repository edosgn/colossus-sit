<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CuentaRepository")
 */
class Cuenta
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
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Banco", inversedBy="cuentas")
     **/
    protected $banco;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Concepto", mappedBy="cuenta")
     */
    protected $conceptos;  

    public function __construct() {
        $this->conceptos = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Cuenta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Cuenta
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set banco
     *
     * @param \AppBundle\Entity\Banco $banco
     *
     * @return Cuenta
     */
    public function setBanco(\AppBundle\Entity\Banco $banco = null)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return \AppBundle\Entity\Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Add concepto
     *
     * @param \AppBundle\Entity\Concepto $concepto
     *
     * @return Cuenta
     */
    public function addConcepto(\AppBundle\Entity\Concepto $concepto)
    {
        $this->conceptos[] = $concepto;

        return $this;
    }

    /**
     * Remove concepto
     *
     * @param \AppBundle\Entity\Concepto $concepto
     */
    public function removeConcepto(\AppBundle\Entity\Concepto $concepto)
    {
        $this->conceptos->removeElement($concepto);
    }

    /**
     * Get conceptos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptos()
    {
        return $this->conceptos;
    }
}
