<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLicenciaTrancito
 *
 * @ORM\Table(name="user_licencia_trancito")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserLicenciaTrancitoRepository")
 */
class UserLicenciaTrancito
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropietarioVehiculo", inversedBy="facturas")
     **/
    protected $propietarioVehiculo;


    /**
     * Get id
     *
     * @return integer
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
     * @return UserLicenciaTrancito
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
     * @return UserLicenciaTrancito
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
     * Set propietarioVehiculo
     *
     * @param \AppBundle\Entity\PropietarioVehiculo $propietarioVehiculo
     *
     * @return UserLicenciaTrancito
     */
    public function setPropietarioVehiculo(\AppBundle\Entity\PropietarioVehiculo $propietarioVehiculo = null)
    {
        $this->propietarioVehiculo = $propietarioVehiculo;

        return $this;
    }

    /**
     * Get propietarioVehiculo
     *
     * @return \AppBundle\Entity\PropietarioVehiculo
     */
    public function getPropietarioVehiculo()
    {
        return $this->propietarioVehiculo;
    }
}
