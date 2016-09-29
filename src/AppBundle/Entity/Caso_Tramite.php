<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caso_Tramite
 *
 * @ORM\Table(name="caso__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Caso_TramiteRepository")
 */
class Caso_Tramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo_Tramite", inversedBy="casosTramite")
     **/
    protected $tipo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Campo_Tramite", mappedBy="casoTramite")
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
     * @return Caso_Tramite
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
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipo_Tramite $tipo
     *
     * @return Caso_Tramite
     */
    public function setTipo(\AppBundle\Entity\Tipo_Tramite $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipo_Tramite
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add camposTramite
     *
     * @param \AppBundle\Entity\Campo_Tramite $camposTramite
     *
     * @return Caso_Tramite
     */
    public function addCamposTramite(\AppBundle\Entity\Campo_Tramite $camposTramite)
    {
        $this->camposTramite[] = $camposTramite;

        return $this;
    }

    /**
     * Remove camposTramite
     *
     * @param \AppBundle\Entity\Campo_Tramite $camposTramite
     */
    public function removeCamposTramite(\AppBundle\Entity\Campo_Tramite $camposTramite)
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
}
