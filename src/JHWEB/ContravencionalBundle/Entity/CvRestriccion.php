<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvRestriccion
 *
 * @ORM\Table(name="cv_restriccion")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvRestriccionRepository")
 */
class CvRestriccion
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
     * @ORM\Column(name="id_foranea", type="string", length=5)
     */
    private $idForanea;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo", inversedBy="notificaciones") */
    private $vehiculo;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="notificaciones") */
    private $ciudadano;

    /** @ORM\ManyToOne(targetEntity="CvCfgTipoRestriccion", inversedBy="notificaciones") */
    private $tipoRestriccion;





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
     * Set idForanea
     *
     * @param string $idForanea
     *
     * @return CvRestriccion
     */
    public function setIdForanea($idForanea)
    {
        $this->idForanea = $idForanea;

        return $this;
    }

    /**
     * Get idForanea
     *
     * @return string
     */
    public function getIdForanea()
    {
        return $this->idForanea;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CvRestriccion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set vehiculo
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculo
     *
     * @return CvRestriccion
     */
    public function setVehiculo(\AppBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \AppBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set ciudadano
     *
     * @param \AppBundle\Entity\Ciudadano $ciudadano
     *
     * @return CvRestriccion
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

    /**
     * Set tipoRestriccion
     *
     * @param \JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion $tipoRestriccion
     *
     * @return CvRestriccion
     */
    public function setTipoRestriccion(\JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion $tipoRestriccion = null)
    {
        $this->tipoRestriccion = $tipoRestriccion;

        return $this;
    }

    /**
     * Get tipoRestriccion
     *
     * @return \JHWEB\ContravencionalBundle\Entity\CvCfgTipoRestriccion
     */
    public function getTipoRestriccion()
    {
        return $this->tipoRestriccion;
    }
}
