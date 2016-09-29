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
     * @var string
     *
     * @ORM\Column(name="datosCuenta", type="string", length=255)
     */
    private $datosCuenta;


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
     * Set datosCuenta
     *
     * @param string $datosCuenta
     *
     * @return Cuenta
     */
    public function setDatosCuenta($datosCuenta)
    {
        $this->datosCuenta = $datosCuenta;

        return $this;
    }

    /**
     * Get datosCuenta
     *
     * @return string
     */
    public function getDatosCuenta()
    {
        return $this->datosCuenta;
    }
}

