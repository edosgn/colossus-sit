<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipos_Id
 *
 * @ORM\Table(name="tipos__id")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tipos_IdRepository")
 */
class Tipos_Id
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

