<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvSenial
 *
 * @ORM\Table(name="msv_senial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvSenialRepository")
 */

class MsvSenial
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="x_destino", type="integer", nullable=false)
     */
    private $xDestino;
	 
	/**
     * @var \MsvInventarioSenial
     *
     * @ORM\ManyToOne(targetEntity="MsvInventarioSenial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventario_senial_id", referencedColumnName="id")
     * })
     */
    private $inventarioSenialId;

    /**
     * @var \TipoSenal
     *
     * @ORM\ManyToOne(targetEntity="CfgTipoSenial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_senial_id", referencedColumnName="id")
     * })
     */
    private $tipoSenal;

    /**
     * @var \TipoDestino
     *
     * @ORM\ManyToOne(targetEntity="CfgTipoDestino")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_destino_id", referencedColumnName="id")
     * })
     */
    private $tipoDestino;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=500, nullable=true)
     */
    private $archivo;

    /**
     * Set xDestino
     *
     * @param integer $xDestino
     *
     * @return MsvSenial
     */
    public function setXDestino($xDestino)
    {
        $this->xDestino = $xDestino;

        return $this;
    }

    /**
     * Get xDestino
     *
     * @return integer
     */
    public function getXDestino()
    {
        return $this->xDestino;
    }
	

	/**
     * Set inventarioSenialId
     *
     * @param \AppBundle\Entity\MsvInventarioSenial $inventarioSenalId
     *
     * @return MsvSenial
     */
    public function setInventarioSenialId(\AppBundle\Entity\MsvInventarioSenial $inventarioSenialId = null)
    {
        $this->inventarioSenialId = $inventarioSenialId;

        return $this;
    }

	/**
     * Get inventarioSenialId
     *
     * @return \AppBundle\Entity\MsvInventarioSenial
     */
    public function getInventarioSenialId()
    {
        return $this->inventarioSenialId;
    }
	
	/**
     * Set destino
     *
     * @param \AppBundle\Entity\CfgTipoDestino $tipoDestino
     *
     * @return MsvSenial
     */
    public function setTipoDestino(\AppBundle\Entity\CfgTipoDestino $tipoDestino = null)
    {
        $this->tipoDestino = $tipoDestino;

        return $this;
    }

    /**
     * Get tipoDestino
     *
     * @return \AppBundle\Entity\TipoDestino
     */
    public function getTipoDestino()
    {
        return $this->tipoDestino;
    }
	
    /**
     * Set senal
     *
     * @param \AppBundle\Entity\CfgTipoSenial $tipoSenal
     *
     * @return MsvSenial
     */
    public function setTipoSenal(\AppBundle\Entity\CfgTipoSenial $tipoSenal = null)
    {
        $this->tipoSenal = $tipoSenal;

        return $this;
    }

    /**
     * Get tipoSenal
     *
     * @return \AppBundle\Entity\CfgTipoSenial
     */
    public function getTipoSenal()
    {
        return $this->tipoSenal;
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
     * Set archivo
     *
     * @param string $archivo
     *
     * @return MsvSenial
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }
}

