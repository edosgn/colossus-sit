<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvSenialInventario
 *
 * @ORM\Table(name="sv_senial_inventario")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvSenialInventarioRepository")
 */
class SvSenialInventario
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="consecutivo", type="string", length=10)
     */
    private $consecutivo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoInventario", type="string", length=50)
     */
    private $tipoInventario;

    /** @ORM\ManyToOne(targetEntity="SvCfgSenialTipo", inversedBy="seniales") */
    private $tipoSenial;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inventarios") */
    private $municipio;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SvSenialInventario
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set consecutivo
     *
     * @param string $consecutivo
     *
     * @return SvSenialInventario
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return string
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }
}

