<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuerpoTramite
 *
 * @ORM\Table(name="cuerpo_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CuerpoTramiteRepository")
 */
class CuerpoTramite
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
     * @var int
     *
     * @ORM\Column(name="valorCampo", type="integer")
     */
    private $valorCampo;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoTramite", inversedBy="cuerposTramite")
     **/
    protected $tipoTramite;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CampoTabla", inversedBy="cuerposTramite")
     **/
    protected $campoTabla;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PagoTramite", mappedBy="cuerpoTramite")
     **/

    protected $pagosTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HistoriaTramite", mappedBy="cuerpoTramite")
     **/
    
    protected $historialesTramite;

     public function __construct() {
        $this->pagosTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historialesTramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set valorCampo
     *
     * @param integer $valorCampo
     *
     * @return CuerpoTramite
     */
    public function setValorCampo($valorCampo)
    {
        $this->valorCampo = $valorCampo;

        return $this;
    }

    /**
     * Get valorCampo
     *
     * @return integer
     */
    public function getValorCampo()
    {
        return $this->valorCampo;
    }

    /**
     * Set tipoTramite
     *
     * @param \AppBundle\Entity\TipoTramite $tipoTramite
     *
     * @return CuerpoTramite
     */
    public function setTipoTramite(\AppBundle\Entity\TipoTramite $tipoTramite = null)
    {
        $this->tipoTramite = $tipoTramite;

        return $this;
    }

    /**
     * Get tipoTramite
     *
     * @return \AppBundle\Entity\Tipo_Tramite
     */
    public function getTipoTramite()
    {
        return $this->tipoTramite;
    }

    /**
     * Set campoTabla
     *
     * @param \AppBundle\Entity\CampoTabla $campoTabla
     *
     * @return CuerpoTramite
     */
    public function setCampoTabla(\AppBundle\Entity\CampoTabla $campoTabla = null)
    {
        $this->campoTabla = $campoTabla;

        return $this;
    }

    /**
     * Get campoTabla
     *
     * @return \AppBundle\Entity\CampoTabla
     */
    public function getCampoTabla()
    {
        return $this->campoTabla;
    }

    /**
     * Add pagosTramite
     *
     * @param \AppBundle\Entity\PagoTramite $pagosTramite
     *
     * @return CuerpoTramite
     */
    public function addPagosTramite(\AppBundle\Entity\PagoTramite $pagosTramite)
    {
        $this->pagosTramite[] = $pagosTramite;

        return $this;
    }

    /**
     * Remove pagosTramite
     *
     * @param \AppBundle\Entity\PagoTramite $pagosTramite
     */
    public function removePagosTramite(\AppBundle\Entity\PagoTramite $pagosTramite)
    {
        $this->pagosTramite->removeElement($pagosTramite);
    }

    /**
     * Get pagosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagosTramite()
    {
        return $this->pagosTramite;
    }

    /**
     * Add historialesTramite
     *
     * @param \AppBundle\Entity\HistoriaTramite $historialesTramite
     *
     * @return CuerpoTramite
     */
    public function addHistorialesTramite(\AppBundle\Entity\HistoriaTramite $historialesTramite)
    {
        $this->historialesTramite[] = $historialesTramite;

        return $this;
    }

    /**
     * Remove historialesTramite
     *
     * @param \AppBundle\Entity\HistoriaTramite $historialesTramite
     */
    public function removeHistorialesTramite(\AppBundle\Entity\HistoriaTramite $historialesTramite)
    {
        $this->historialesTramite->removeElement($historialesTramite);
    }

    /**
     * Get historialesTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistorialesTramite()
    {
        return $this->historialesTramite;
    }
}
