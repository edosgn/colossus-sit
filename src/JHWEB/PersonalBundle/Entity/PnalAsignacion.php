<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalAsignacion
 *
 * @ORM\Table(name="pnal_asignacion")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalAsignacionRepository")
 */
class PnalAsignacion
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

