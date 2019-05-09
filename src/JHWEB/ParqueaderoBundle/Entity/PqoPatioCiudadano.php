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

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PqoPatioCiudadano
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set ciudadano
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano
     *
     * @return PqoPatioCiudadano
     */
    public function setCiudadano(\JHWEB\UsuarioBundle\Entity\UserCiudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCiudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }

    /**
     * Set patio
     *
     * @param \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio
     *
     * @return PqoPatioCiudadano
     */
    public function setPatio(\JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio $patio = null)
    {
        $this->patio = $patio;

        return $this;
    }

    /**
     * Get patio
     *
     * @return \JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio
     */
    public function getPatio()
    {
        return $this->patio;
    }
}
