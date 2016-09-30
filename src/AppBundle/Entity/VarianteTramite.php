<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VarianteTramite
 *
 * @ORM\Table(name="variante_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VarianteTramiteRepository")
 */
class VarianteTramite
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
     * @ORM\Column(name="descripcionVariante", type="string", length=255)
     */
    private $descripcionVariante;

    

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoTramite", inversedBy="variantesTramite")
     **/
    protected $tipoTramite;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocumentoTramite", mappedBy="varianteTramite")
     **/
    protected $documentosTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HistoriaTramite", mappedBy="varianteTramite")
     **/
    protected $historialesTramite;


    public function __construct() {
        $this->documentosTramite = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcionVariante
     *
     * @param string $descripcionVariante
     *
     * @return VarianteTramite
     */
    public function setDescripcionVariante($descripcionVariante)
    {
        $this->descripcionVariante = $descripcionVariante;

        return $this;
    }

    /**
     * Get descripcionVariante
     *
     * @return string
     */
    public function getDescripcionVariante()
    {
        return $this->descripcionVariante;
    }

    /**
     * Set tipoTramite
     *
     * @param \AppBundle\Entity\TipoTramite $tipoTramite
     *
     * @return VarianteTramite
     */
    public function setTipoTramite(\AppBundle\Entity\TipoTramite $tipoTramite = null)
    {
        $this->tipoTramite = $tipoTramite;

        return $this;
    }

    /**
     * Get tipoTramite
     *
     * @return \AppBundle\Entity\TipoTramite
     */
    public function getTipoTramite()
    {
        return $this->tipoTramite;
    }

    /**
     * Add documentosTramite
     *
     * @param \AppBundle\Entity\DocumentoTramite $documentosTramite
     *
     * @return VarianteTramite
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

    /**
     * Add historialesTramite
     *
     * @param \AppBundle\Entity\HistoriaTramite $historialesTramite
     *
     * @return VarianteTramite
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
