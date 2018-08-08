<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MrfsvHu09
 *
 * @ORM\Table(name="mrfsv_hu09")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MrfsvHu09Repository")
 */

class MrfsvHu09
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
     * @var \MrfsvHu08
     *
     * @ORM\ManyToOne(targetEntity="MrfsvHu08")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mrfsv_hu08_id", referencedColumnName="id")
     * })
     */
    private $mrfsvHu08Id;

    /**
     * @var \TipoSenal
     *
     * @ORM\ManyToOne(targetEntity="TipoSenal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_senal_id", referencedColumnName="id")
     * })
     */
    private $tipoSenal;

    /**
     * @var \TipoDestino
     *
     * @ORM\ManyToOne(targetEntity="TipoDestino")
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
     * @return MrfsvHu09
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
     * Set mrfsvHu08Id
     *
     * @param \AppBundle\Entity\MrfsvHu08 $mrfsvHu08Id
     *
     * @return MrfsvHu09
     */
    public function setMrfsvHu08Id(\AppBundle\Entity\MrfsvHu08 $mrfsvHu08Id = null)
    {
        $this->mrfsvHu08Id = $mrfsvHu08Id;

        return $this;
    }

	/**
     * Get mrfsvHu08Id
     *
     * @return \AppBundle\Entity\MrfsvHu08
     */
    public function getMrfsvHu08Id()
    {
        return $this->mrfsvHu08Id;
    }
	
	/**
     * Set destino
     *
     * @param \AppBundle\Entity\TipoDestino $tipoDestino
     *
     * @return MrfsvHu09
     */
    public function setTipoDestino(\AppBundle\Entity\TipoDestino $tipoDestino = null)
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
     * @param \AppBundle\Entity\TipoSenal $tipoSenal
     *
     * @return MrfsvHu09
     */
    public function setTipoSenal(\AppBundle\Entity\TipoSenal $tipoSenal = null)
    {
        $this->tipoSenal = $tipoSenal;

        return $this;
    }

    /**
     * Get tipoSenal
     *
     * @return \AppBundle\Entity\TipoSenal
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
     * @return MrfsvHu08
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

