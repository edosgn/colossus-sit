<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documeto_Tramite
 *
 * @ORM\Table(name="documeto__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Documeto_TramiteRepository")
 */
class Documeto_Tramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Documento", inversedBy="documentosTramite")
     **/
    protected $documento;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Variante_tramite", inversedBy="documentosTramite")
     **/
    protected $varianteTramite;

  
   

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set documento
     *
     * @param \AppBundle\Entity\Documento $documento
     *
     * @return Documeto_Tramite
     */
    public function setDocumento(\AppBundle\Entity\Documento $documento = null)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \AppBundle\Entity\Documento
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set varianteTramite
     *
     * @param \AppBundle\Entity\Variante_tramite $varianteTramite
     *
     * @return Documeto_Tramite
     */
    public function setVarianteTramite(\AppBundle\Entity\Variante_tramite $varianteTramite = null)
    {
        $this->variante_Tramite = $varianteTramite;

        return $this;
    }

    /**
     * Get varianteTramite
     *
     * @return \AppBundle\Entity\Variante_tramite
     */
    public function getVarianteTramite()
    {
        return $this->varianteTramite;
    }
}
