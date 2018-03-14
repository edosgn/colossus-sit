<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuloSistema
 *
 * @ORM\Table(name="modulo_sistema")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuloSistemaRepository")
 */
class ModuloSistema
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
     * @ORM\Column(name="NombreModulo", type="string", length=145)
     */
    private $nombreModulo;


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
     * Set nombreModulo
     *
     * @param string $nombreModulo
     *
     * @return ModuloSistema
     */
    public function setNombreModulo($nombreModulo)
    {
        $this->nombreModulo = $nombreModulo;

        return $this;
    }

    /**
     * Get nombreModulo
     *
     * @return string
     */
    public function getNombreModulo()
    {
        return $this->nombreModulo;
    }
}
