<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento_Tramite
 *
 * @ORM\Table(name="documento__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Documento_TramiteRepository")
 */
class Documento_Tramite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Documento", inversedBy="documentosTramite") */
    protected $documento;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Variante_Tramite", inversedBy="documentosTramite") */
    protected $variante;


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
     * Set documento
     *
     * @param \AppBundle\Entity\Documento $documento
     *
     * @return Documento_Tramite
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
     * Set variante
     *
     * @param \AppBundle\Entity\Variante $variante
     *
     * @return Documento_Tramite
     */
    public function setVariante(\AppBundle\Entity\Variante $variante = null)
    {
        $this->variante = $variante;

        return $this;
    }

    /**
     * Get variante
     *
     * @return \AppBundle\Entity\Variante
     */
    public function getVariante()
    {
        return $this->variante;
    }
}
