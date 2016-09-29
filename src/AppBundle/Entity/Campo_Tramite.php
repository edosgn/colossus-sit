<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campo_Tramite
 *
 * @ORM\Table(name="campo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Campo_TramiteRepository")
 */
class Campo_Tramite
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

