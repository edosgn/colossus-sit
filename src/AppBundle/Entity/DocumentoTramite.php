<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoTramite
 *
 * @ORM\Table(name="documento_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoTramiteRepository")
 */
class DocumentoTramite
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

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\VarianteTramite", inversedBy="documentosTramite") */
    protected $varianteTramite;


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
     * @return DocumentoTramite
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
     * @param \AppBundle\Entity\VarianteTramite $varianteTramite
     *
     * @return DocumentoTramite
     */
    public function setVarianteTramite(\AppBundle\Entity\VarianteTramite $varianteTramite = null)
    {
        $this->varianteTramite = $varianteTramite;

        return $this;
    }

    /**
     * Get varianteTramite
     *
     * @return \AppBundle\Entity\VarianteTramite
     */
    public function getVarianteTramite()
    {
        return $this->varianteTramite;
    }
}
