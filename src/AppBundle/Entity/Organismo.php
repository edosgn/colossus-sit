<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organismo
 *
 * @ORM\Table(name="organismo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganismoRepository")
 */
class Organismo
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
     * @ORM\Column(name="nombreOrganismo", type="string", length=255)
     */
    private $nombreOrganismo;


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
     * Set nombreOrganismo
     *
     * @param string $nombreOrganismo
     *
     * @return Organismo
     */
    public function setNombreOrganismo($nombreOrganismo)
    {
        $this->nombreOrganismo = $nombreOrganismo;

        return $this;
    }

    /**
     * Get nombreOrganismo
     *
     * @return string
     */
    public function getNombreOrganismo()
    {
        return $this->nombreOrganismo;
    }
}

