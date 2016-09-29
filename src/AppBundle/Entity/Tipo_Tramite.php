<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo_Tramite
 *
 * @ORM\Table(name="tipo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Tipo_TramiteRepository")
 */
class Tipo_Tramite
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
     * @ORM\Column(name="nombreTramite", type="string", length=255)
     */
    private $nombreTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="smldv", type="string", length=255)
     */
    private $smldv;

    /**
     * @var int
     *
     * @ORM\Column(name="redondeo", type="integer")
     */
    private $redondeo;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="afectacion", type="string", length=255)
     */
    private $afectacion;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Caso_Tramite", mappedBy="tipo")
     **/
    protected $casosTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Variante_Tramite", mappedBy="tipo")
     **/
    protected $variantesTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Campo_Tramite", mappedBy="tipo")
     **/
    protected $camposTramite;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cuerpo_Tramite", mappedBy="tipo")
     **/
    protected $cuerposTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Conceptos_Tramite", mappedBy="tipo")
     **/
    protected $conceptosTramite;


    public function __construct() {
        $this->casosTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->variantesTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->camposTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cuerposTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conceptosTramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreTramite
     *
     * @param string $nombreTramite
     *
     * @return Tipo_Tramite
     */
    public function setNombreTramite($nombreTramite)
    {
        $this->nombreTramite = $nombreTramite;

        return $this;
    }

    /**
     * Get nombreTramite
     *
     * @return string
     */
    public function getNombreTramite()
    {
        return $this->nombreTramite;
    }

    /**
     * Set smldv
     *
     * @param string $smldv
     *
     * @return Tipo_Tramite
     */
    public function setSmldv($smldv)
    {
        $this->smldv = $smldv;

        return $this;
    }

    /**
     * Get smldv
     *
     * @return string
     */
    public function getSmldv()
    {
        return $this->smldv;
    }

    /**
     * Set redondeo
     *
     * @param integer $redondeo
     *
     * @return Tipo_Tramite
     */
    public function setRedondeo($redondeo)
    {
        $this->redondeo = $redondeo;

        return $this;
    }

    /**
     * Get redondeo
     *
     * @return integer
     */
    public function getRedondeo()
    {
        return $this->redondeo;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     *
     * @return Tipo_Tramite
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set afectacion
     *
     * @param string $afectacion
     *
     * @return Tipo_Tramite
     */
    public function setAfectacion($afectacion)
    {
        $this->afectacion = $afectacion;

        return $this;
    }

    /**
     * Get afectacion
     *
     * @return string
     */
    public function getAfectacion()
    {
        return $this->afectacion;
    }

    /**
     * Add casosTramite
     *
     * @param \AppBundle\Entity\Caso_Tramite $casosTramite
     *
     * @return Tipo_Tramite
     */
    public function addCasosTramite(\AppBundle\Entity\Caso_Tramite $casosTramite)
    {
        $this->casosTramite[] = $casosTramite;

        return $this;
    }

    /**
     * Remove casosTramite
     *
     * @param \AppBundle\Entity\Caso_Tramite $casosTramite
     */
    public function removeCasosTramite(\AppBundle\Entity\Caso_Tramite $casosTramite)
    {
        $this->casosTramite->removeElement($casosTramite);
    }

    /**
     * Get casosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosTramite()
    {
        return $this->casosTramite;
    }

    /**
     * Add variantesTramite
     *
     * @param \AppBundle\Entity\Variante_Tramite $variantesTramite
     *
     * @return Tipo_Tramite
     */
    public function addVariantesTramite(\AppBundle\Entity\Variante_Tramite $variantesTramite)
    {
        $this->variantesTramite[] = $variantesTramite;

        return $this;
    }

    /**
     * Remove variantesTramite
     *
     * @param \AppBundle\Entity\Variante_Tramite $variantesTramite
     */
    public function removeVariantesTramite(\AppBundle\Entity\Variante_Tramite $variantesTramite)
    {
        $this->variantesTramite->removeElement($variantesTramite);
    }

    /**
     * Get variantesTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariantesTramite()
    {
        return $this->variantesTramite;
    }

    /**
     * Add camposTramite
     *
     * @param \AppBundle\Entity\Campo_Tramite $camposTramite
     *
     * @return Tipo_Tramite
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

    /**
     * Add cuerposTramite
     *
     * @param \AppBundle\Entity\Cuerpo_Tramite $cuerposTramite
     *
     * @return Tipo_Tramite
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

    /**
     * Add conceptosTramite
     *
     * @param \AppBundle\Entity\Conceptos_Tramite $conceptosTramite
     *
     * @return Tipo_Tramite
     */
    public function addConceptosTramite(\AppBundle\Entity\Conceptos_Tramite $conceptosTramite)
    {
        $this->conceptosTramite[] = $conceptosTramite;

        return $this;
    }

    /**
     * Remove conceptosTramite
     *
     * @param \AppBundle\Entity\Conceptos_Tramite $conceptosTramite
     */
    public function removeConceptosTramite(\AppBundle\Entity\Conceptos_Tramite $conceptosTramite)
    {
        $this->conceptosTramite->removeElement($conceptosTramite);
    }

    /**
     * Get conceptosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptosTramite()
    {
        return $this->conceptosTramite;
    }
}
