<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuerpo_Tramite
 *
 * @ORM\Table(name="cuerpo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cuerpo_TramiteRepository")
 */
class Cuerpo_Tramite
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
     * @ORM\Column(name="valorCampo", type="integer")
     */
    private $valorCampo;


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
     * Set valorCampo
     *
     * @param integer $valorCampo
     *
     * @return Cuerpo_Tramite
     */
    public function setValorCampo($valorCampo)
    {
        $this->valorCampo = $valorCampo;

        return $this;
    }

    /**
     * Get valorCampo
     *
     * @return int
     */
    public function getValorCampo()
    {
        return $this->valorCampo;
    }
}

