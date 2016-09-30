<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CasoTramite
 *
 * @ORM\Table(name="caso_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CasoTramiteRepository")
 */
class CasoTramite
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
     * @ORM\Column(name="nombreCaso", type="string", length=255)
     */
    private $nombreCaso;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoTramite", inversedBy="casosTramite")
     **/
    protected $tipoTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CampoTramite", mappedBy="casoTramite")
     **/
    protected $camposTramite;

    public function __construct() {
        $this->campos_Tramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreCaso
     *
     * @param string $nombreCaso
     *
     * @return CasoTramite
     */
    public function setNombreCaso($nombreCaso)
    {
        $this->nombreCaso = $nombreCaso;

        return $this;
    }

    /**
     * Get nombreCaso
     *
     * @return string
     */
    public function getNombreCaso()
    {
        return $this->nombreCaso;
    }

    

    /**
     * Add camposTramite
     *
     * @param \AppBundle\Entity\CampoTramite $camposTramite
     *
     * @return CasoTramite
     */
    public function addCamposTramite(\AppBundle\Entity\CampoTramite $camposTramite)
    {
        $this->camposTramite[] = $camposTramite;

        return $this;
    }

    /**
     * Remove camposTramite
     *
     * @param \AppBundle\Entity\CampoTramite $camposTramite
     */
    public function removeCamposTramite(\AppBundle\Entity\CampoTramite $camposTramite)
    {
        $this->camposTramite->removeElement($camposTramite);
    }

    /**
     * Get camposTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCamposTramite()
    {
        return $this->camposTramite;
    }

    /**
     * Set tipoTramite
     *
     * @param \AppBundle\Entity\TipoTramite $tipoTramite
     *
     * @return CasoTramite
     */
    public function setTipoTramite(\AppBundle\Entity\TipoTramite $tipoTramite = null)
    {
        $this->tipoTramite = $tipoTramite;

        return $this;
    }

    /**
     * Get tipoTramite
     *
     * @return \AppBundle\Entity\TipoTramite
     */
    public function getTipoTramite()
    {
        return $this->tipoTramite;
    }
}
