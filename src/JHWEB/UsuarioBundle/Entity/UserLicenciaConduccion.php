<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLicenciaConduccion
 *
 * @ORM\Table(name="user_licencia_conduccion")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLicenciaConduccionRepository")
 */
class UserLicenciaConduccion
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
     * @ORM\Column(name="numero", type="bigint")
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroRunt", type="bigint")
     */
    private $numeroRunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="licenciasConduccion") */
    private $sedeOperativa;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgLicenciaConduccionCategoria", inversedBy="licenciasConduccion") */
    private $categoria;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="licenciasConduccion") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Servicio", inversedBy="licenciasConduccion") */
    private $servicio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramiteFactura", inversedBy="licenciasConduccion") */
    private $tramiteFactura;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="licenciasConduccion") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pais", inversedBy="licenciasConduccion") */
    private $pais;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

