<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caso
 *
 * @ORM\Table(name="caso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CasoRepository")
 */
class Caso
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="casos")
     **/
    protected $tramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TramiteEspecifico", mappedBy="caso")
     */
    protected $tramitesEspecifico;

    public function __construct() {
        $this->tramitesEspecifico = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Caso
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return Caso
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Add tramitesEspecifico
     *
     * @param \AppBundle\Entity\TramiteEspecifico $tramitesEspecifico
     *
     * @return Caso
     */
    public function addTramitesEspecifico(\AppBundle\Entity\TramiteEspecifico $tramitesEspecifico)
    {
        $this->tramitesEspecifico[] = $tramitesEspecifico;

        return $this;
    }

    /**
     * Remove tramitesEspecifico
     *
     * @param \AppBundle\Entity\TramiteEspecifico $tramitesEspecifico
     */
    public function removeTramitesEspecifico(\AppBundle\Entity\TramiteEspecifico $tramitesEspecifico)
    {
        $this->tramitesEspecifico->removeElement($tramitesEspecifico);
    }

    /**
     * Get tramitesEspecifico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTramitesEspecifico()
    {
        return $this->tramitesEspecifico;
    }
}