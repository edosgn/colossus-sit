<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CampoTabla
 *
 * @ORM\Table(name="campo_tabla")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampoTablaRepository")
 */
class CampoTabla
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CasoTramite", inversedBy="camposTramite")
     **/
    protected $casoTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CuerpoTramite", mappedBy="campoTabla")
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
     * @return CampoTabla
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
     * @return CampoTabla
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
     * @param \AppBundle\Entity\CasoTramite $casoTramite
     *
     * @return CampoTabla
     */
    public function setCasoTramite(\AppBundle\Entity\CasoTramite $casoTramite = null)
    {
        $this->casoTramite = $casoTramite;

        return $this;
    }

    /**
     * Get casoTramite
     *
     * @return \AppBundle\Entity\CasoTramite
     */
    public function getCasoTramite()
    {
        return $this->casoTramite;
    }

    /**
     * Add cuerposTramite
     *
     * @param \AppBundle\Entity\CuerpoTramite $cuerposTramite
     *
     * @return CampoTabla
     */
    public function addCuerposTramite(\AppBundle\Entity\CuerpoTramite $cuerposTramite)
    {
        $this->cuerposTramite[] = $cuerposTramite;

        return $this;
    }

    /**
     * Remove cuerposTramite
     *
     * @param \AppBundle\Entity\CuerpoTramite $cuerposTramite
     */
    public function removeCuerposTramite(\AppBundle\Entity\CuerpoTramite $cuerposTramite)
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
