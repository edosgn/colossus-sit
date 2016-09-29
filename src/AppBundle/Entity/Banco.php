<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banco
 *
 * @ORM\Table(name="banco")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BancoRepository")
 */
class Banco
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
     * @ORM\Column(name="nombreBanco", type="string", length=255)
     */
    private $nombreBanco;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cuenta", mappedBy="banco")
     **/
    protected $cuentas;

    public function __construct() {
        $this->cuentas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreBanco
     *
     * @param string $nombreBanco
     *
     * @return Banco
     */
    public function setNombreBanco($nombreBanco)
    {
        $this->nombreBanco = $nombreBanco;

        return $this;
    }

    /**
     * Get nombreBanco
     *
     * @return string
     */
    public function getNombreBanco()
    {
        return $this->nombreBanco;
    }

    /**
     * Add cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Banco
     */
    public function addCuenta(\AppBundle\Entity\Cuenta $cuenta)
    {
        $this->cuentas[] = $cuenta;

        return $this;
    }

    /**
     * Remove cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     */
    public function removeCuenta(\AppBundle\Entity\Cuenta $cuenta)
    {
        $this->cuentas->removeElement($cuenta);
    }

    /**
     * Get cuentas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuentas()
    {
        return $this->cuentas;
    }
}
