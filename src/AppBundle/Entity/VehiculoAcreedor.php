<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehiculoAcreedor
 *
 * @ORM\Table(name="vehiculo_acreedor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculoAcreedorRepository")
 */
class VehiculoAcreedor
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="vehiculoacreedores")
     **/
    protected $vehiculo;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Banco", inversedBy="vehiculoacreedores")
     **/
    protected $banco;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;  


}

