<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 */
class Documento
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
     * @ORM\Column(name="nombreDocuemento", type="string", length=255)
     */
    private $nombreDocuemento;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocumentoTramite", mappedBy="documento")
     **/
    protected $documentosTramite;


    public function __construct() {
        $this->documentosTramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreDocuemento
     *
     * @param string $nombreDocuemento
     *
     * @return Documento
     */
    public function setNombreDocuemento($nombreDocuemento)
    {
        $this->nombreDocuemento = $nombreDocuemento;

        return $this;
    }

    /**
     * Get nombreDocuemento
     *
     * @return string
     */
    public function getNombreDocuemento()
    {
        return $this->nombreDocuemento;
    }

    /**
     * Add documentosTramite
     *
     * @param \AppBundle\Entity\DocumentoTramite $documentosTramite
     *
     * @return Documento
     */
    public function addDocumentosTramite(\AppBundle\Entity\DocumentoTramite $documentosTramite)
    {
        $this->documentosTramite[] = $documentosTramite;

        return $this;
    }

    /**
     * Remove documentosTramite
     *
     * @param \AppBundle\Entity\DocumentoTramite $documentosTramite
     */
    public function removeDocumentosTramite(\AppBundle\Entity\DocumentoTramite $documentosTramite)
    {
        $this->documentosTramite->removeElement($documentosTramite);
    }

    /**
     * Get documentosTramite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentosTramite()
    {
        return $this->documentosTramite;
    }
}
