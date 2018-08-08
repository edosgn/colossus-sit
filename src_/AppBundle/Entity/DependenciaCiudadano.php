<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DependenciaCiudadano
 *
 * @ORM\Table(name="dependencia_ciudadano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DependenciaCiudadanoRepository")
 */
class DependenciaCiudadano
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
     * @ORM\Column(name="cargo", type="string", length=45)
     */
    private $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dependencia", inversedBy="dependenciasCiudadanos")
     **/
    protected $dependencia;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="dependenciasCiudadanos")
     **/
    protected $ciudadano;


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
     * Set cargo
     *
     * @param string $cargo
     *
     * @return DependenciaCiudadano
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set dependencia
     *
     * @param \AppBundle\Entity\Dependencia $dependencia
     *
     * @return DependenciaCiudadano
     */
    public function setDependencia(\AppBundle\Entity\Dependencia $dependencia = null)
    {
        $this->dependencia = $dependencia;

        return $this;
    }

    /**
     * Get dependencia
     *
     * @return \AppBundle\Entity\Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return DependenciaCiudadano
     */
    public function setCiudadano(\AppBundle\Entity\Ciudadano $ciudadano = null)
    {
        $this->ciudadano = $ciudadano;

        return $this;
    }

    /**
     * Get ciudadano
     *
     * @return \AppBundle\Entity\Ciudadano
     */
    public function getCiudadano()
    {
        return $this->ciudadano;
    }
}
