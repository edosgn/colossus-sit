<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Variante
 *
 * @ORM\Table(name="variante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VarianteRepository")
 */
class Variante
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
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="variantes")
     **/
    protected $tramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TramiteEspecifico", mappedBy="variante")
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
     * @return Variante
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
     * @return Variante
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
     * @return Variante
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

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Variante
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
