<?php

namespace JHWEB\ParqueaderoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PqoPatioCiudadano
 *
 * @ORM\Table(name="pqo_patio_ciudadano")
 * @ORM\Entity(repositoryClass="JHWEB\ParqueaderoBundle\Repository\PqoPatioCiudadanoRepository")
 */
class PqoPatioCiudadano
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserCiudadano", inversedBy="patios") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="PqoCfgPatio", inversedBy="ciudadanos") */
    private $patio;


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
