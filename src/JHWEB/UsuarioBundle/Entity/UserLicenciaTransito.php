<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLicenciaTransito
 *
 * @ORM\Table(name="user_licencia_transito")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLicenciaTransitoRepository")
 */
class UserLicenciaTransito
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
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="activo", type="string", length=100)
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\VehiculoBundle\Entity\VhloPropietario", inversedBy="licenciasTransito")
     **/
    protected $propietario;


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
     * Set numero
     *
     * @param string $numero
     *
     * @return UserLicenciaTransito
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return UserLicenciaTransito
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set activo
     *
     * @param string $activo
     *
     * @return UserLicenciaTransito
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return string
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set propietario
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario
     *
     * @return UserLicenciaTransito
     */
    public function setPropietario(\JHWEB\VehiculoBundle\Entity\VhloPropietario $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloPropietario
     */
    public function getPropietario()
    {
        return $this->propietario;
    }
}
