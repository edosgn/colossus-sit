<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuerpo_Tramite
 *
 * @ORM\Table(name="cuerpo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cuerpo_TramiteRepository")
 */
class Cuerpo_Tramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo_Tramite", inversedBy="cuerposTramite")
     **/
    protected $tipo;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Campo_Tabla", inversedBy="cuerposTramite")
     **/
    protected $campoTabla;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pago_Tramite", mappedBy="cuerpoTramite")
     **/

    protected $pagosTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Historia_Tramite", mappedBy="cuerpoTramite")
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
     * @return Cuerpo_Tramite
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
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipo_Tramite $tipo
     *
     * @return Cuerpo_Tramite
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
     * Set campoTabla
     *
     * @param \AppBundle\Entity\Campo_Tabla $campoTabla
     *
     * @return Cuerpo_Tramite
     */
    public function setCampoTabla(\AppBundle\Entity\Campo_Tabla $campoTabla = null)
    {
        $this->campoTabla = $campoTabla;

        return $this;
    }

    /**
     * Get campoTabla
     *
     * @return \AppBundle\Entity\Campo_Tabla
     */
    public function getCampoTabla()
    {
        return $this->campoTabla;
    }

    /**
     * Add pagosTramite
     *
     * @param \AppBundle\Entity\Pago_Tramite $pagosTramite
     *
     * @return Cuerpo_Tramite
     */
    public function addPagosTramite(\AppBundle\Entity\Pago_Tramite $pagosTramite)
    {
        $this->pagosTramite[] = $pagosTramite;

        return $this;
    }

    /**
     * Remove pagosTramite
     *
     * @param \AppBundle\Entity\Pago_Tramite $pagosTramite
     */
    public function removePagosTramite(\AppBundle\Entity\Pago_Tramite $pagosTramite)
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
     * @param \AppBundle\Entity\Historia_Tramite $historialesTramite
     *
     * @return Cuerpo_Tramite
     */
    public function addHistorialesTramite(\AppBundle\Entity\Historia_Tramite $historialesTramite)
    {
        $this->historialesTramite[] = $historialesTramite;

        return $this;
    }

    /**
     * Remove historialesTramite
     *
     * @param \AppBundle\Entity\Historia_Tramite $historialesTramite
     */
    public function removeHistorialesTramite(\AppBundle\Entity\Historia_Tramite $historialesTramite)
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
