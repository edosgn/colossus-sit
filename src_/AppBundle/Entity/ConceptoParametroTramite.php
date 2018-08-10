<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConceptoParametroTramite
 *
 * @ORM\Table(name="concepto_parametro_tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConceptoParametroTramiteRepository")
 */
class ConceptoParametroTramite
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
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramitePrecio", inversedBy="empresas") */
    private $tramitePrecio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\ConceptoParametro", inversedBy="empresas") */
    private $conceptoParametro;


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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return ConceptoParametroTramite
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tramitePrecio
     *
     * @param \AppBundle\Entity\TramitePrecio $tramitePrecio
     *
     * @return ConceptoParametroTramite
     */
    public function setTramitePrecio(\AppBundle\Entity\TramitePrecio $tramitePrecio = null)
    {
        $this->tramitePrecio = $tramitePrecio;

        return $this;
    }

    /**
     * Get tramitePrecio
     *
     * @return \AppBundle\Entity\TramitePrecio
     */
    public function getTramitePrecio()
    {
        return $this->tramitePrecio;
    }

    /**
     * Set conceptoParametro
     *
     * @param \AppBundle\Entity\ConceptoParametro $conceptoParametro
     *
     * @return ConceptoParametroTramite
     */
    public function setConceptoParametro(\AppBundle\Entity\ConceptoParametro $conceptoParametro = null)
    {
        $this->conceptoParametro = $conceptoParametro;

        return $this;
    }

    /**
     * Get conceptoParametro
     *
     * @return \AppBundle\Entity\ConceptoParametro
     */
    public function getConceptoParametro()
    {
        return $this->conceptoParametro;
    }
}
