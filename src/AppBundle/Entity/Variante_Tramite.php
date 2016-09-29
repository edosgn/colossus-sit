<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Variante_Tramite
 *
 * @ORM\Table(name="variante__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Variante_TramiteRepository")
 */
class Variante_Tramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipos_Tramite", inversedBy="variantesTramite")
     **/
    protected $tipo;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Documento_Tramite", mappedBy="varianteTramite")
     **/
    protected $documentosTramite;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Historia_Tramite", mappedBy="varianteTramite")
     **/
    protected $historialesTramite;


    public function __construct() {
        $this->documentosTramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historialesTramite = new \Doctrine\Common\Collections\ArrayCollection();
    }


    
    

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
     * Set descripcionVariante
     *
     * @param string $descripcionVariante
     *
     * @return Variante_Tramite
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
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipos_Tramite $tipo
     *
     * @return Variante_Tramite
     */
    public function setTipo(\AppBundle\Entity\Tipos_Tramite $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipos_Tramite
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add documentosTramite
     *
     * @param \AppBundle\Entity\Documento_Tramite $documentosTramite
     *
     * @return Variante_Tramite
     */
    public function addDocumentosTramite(\AppBundle\Entity\Documento_Tramite $documentosTramite)
    {
        $this->documentosTramite[] = $documentosTramite;

        return $this;
    }

    /**
     * Remove documentosTramite
     *
     * @param \AppBundle\Entity\Documento_Tramite $documentosTramite
     */
    public function removeDocumentosTramite(\AppBundle\Entity\Documento_Tramite $documentosTramite)
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
     * @param \AppBundle\Entity\Historia_Tramite $historialesTramite
     *
     * @return Variante_Tramite
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
