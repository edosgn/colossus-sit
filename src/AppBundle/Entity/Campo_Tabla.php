<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
 
/**
 * Campo_Tabla
 *
 * @ORM\Table(name="campo__tabla")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Campo_TablaRepository")
 */
class Campo_Tabla
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
     * @ORM\Column(name="nombreCampo", type="string", length=255)
     */
    private $nombreCampo;

    /**
     * @var string
     *
     * @ORM\Column(name="arrayCampo", type="string", length=255)
     */
    private $arrayCampo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Caso_Tramite", inversedBy="camposTramite")
     **/
    protected $casoTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cuerpo_Tramite", mappedBy="campoTabla")
     **/
    protected $cuerposTramite;

    public function __construct() {
        $this->cuerposTramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreCampo
     *
     * @param string $nombreCampo
     *
     * @return Campo_Tabla
     */
    public function setNombreCampo($nombreCampo)
    {
        $this->nombreCampo = $nombreCampo;

        return $this;
    }

    /**
     * Get nombreCampo
     *
     * @return string
     */
    public function getNombreCampo()
    {
        return $this->nombreCampo;
    }

    /**
     * Set arrayCampo
     *
     * @param string $arrayCampo
     *
     * @return Campo_Tabla
     */
    public function setArrayCampo($arrayCampo)
    {
        $this->arrayCampo = $arrayCampo;

        return $this;
    }

    /**
     * Get arrayCampo
     *
     * @return string
     */
    public function getArrayCampo()
    {
        return $this->arrayCampo;
    }

    /**
     * Set casoTramite
     *
     * @param \AppBundle\Entity\Caso_Tramite $casoTramite
     *
     * @return Campo_Tabla
     */
    public function setCasoTramite(\AppBundle\Entity\Caso_Tramite $casoTramite = null)
    {
        $this->casoTramite = $casoTramite;

        return $this;
    }

    /**
     * Get casoTramite
     *
     * @return \AppBundle\Entity\Caso_Tramite
     */
    public function getCasoTramite()
    {
        return $this->casoTramite;
    }

    /**
     * Add cuerposTramite
     *
     * @param \AppBundle\Entity\Cuerpo_Tramite $cuerposTramite
     *
     * @return Campo_Tabla
     */
    public function addCuerposTramite(\AppBundle\Entity\Cuerpo_Tramite $cuerposTramite)
    {
        $this->cuerposTramite[] = $cuerposTramite;

        return $this;
    }

    /**
     * Remove cuerposTramite
     *
     * @param \AppBundle\Entity\Cuerpo_Tramite $cuerposTramite
     */
    public function removeCuerposTramite(\AppBundle\Entity\Cuerpo_Tramite $cuerposTramite)
    {
        $this->cuerposTramite->removeElement($cuerposTramite);
    }

    /**
     * Get cuerposTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuerposTramite()
    {
        return $this->cuerposTramite;
    }
}
