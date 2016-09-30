<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CampoTramite
 *
 * @ORM\Table(name="campo_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CampoTramiteRepository")
 */
class CampoTramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoTramite", inversedBy="camposTramite")
     **/
    protected $tipoTramite;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CasoTramite", inversedBy="camposTramite")
     **/
    protected $casoTramite;


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
     * Set tipoTramite
     *
     * @param \AppBundle\Entity\TipoTramite $tipoTramite
     *
     * @return CampoTramite
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
     * Set casoTramite
     *
     * @param \AppBundle\Entity\CasoTramite $casoTramite
     *
     * @return CampoTramite
     */
    public function setCasoTramite(\AppBundle\Entity\CasoTramite $casoTramite = null)
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
}
