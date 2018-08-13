<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CiudadExtranjera
 *
 * @ORM\Table(name="ciudad_extranjera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CiudadExtranjeraRepository")
 */
class CiudadExtranjera
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
     * @ORM\Column(name="nombreCiudadExtranjera", type="string", length=45)
     */
    private $nombreCiudadExtranjera;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pais", inversedBy="ciudaddesExtranjeras")
     **/
    protected $pais;



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
     * Set nombreCiudadExtranjera
     *
     * @param string $nombreCiudadExtranjera
     *
     * @return CiudadExtranjera
     */
    public function setNombreCiudadExtranjera($nombreCiudadExtranjera)
    {
        $this->nombreCiudadExtranjera = $nombreCiudadExtranjera;

        return $this;
    }

    /**
     * Get nombreCiudadExtranjera
     *
     * @return string
     */
    public function getNombreCiudadExtranjera()
    {
        return $this->nombreCiudadExtranjera;
    }

    /**
     * Set pais
     *
     * @param \AppBundle\Entity\Pais $pais
     *
     * @return CiudadExtranjera
     */
    public function setPais(\AppBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }
}
