<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documeto_Tramite
 *
 * @ORM\Table(name="documeto__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Documeto_TramiteRepository")
 */
class Documeto_Tramite
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

