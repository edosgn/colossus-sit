<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgEntidadJudicial
 *
 * @ORM\Table(name="cfg_entidad_judicial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgEntidadJudicialRepository")
 */
class CfgEntidadJudicial
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_divipo", type="string", length=50)
     */
    private $codigoDivipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="inmovilizaciones")
     **/
    protected $municipio;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CfgEntidadJudicial
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigoDivipo
     *
     * @param string $codigoDivipo
     *
     * @return CfgEntidadJudicial
     */
    public function setCodigoDivipo($codigoDivipo)
    {
        $this->codigoDivipo = $codigoDivipo;

        return $this;
    }

    /**
     * Get codigoDivipo
     *
     * @return string
     */
    public function getCodigoDivipo()
    {
        return $this->codigoDivipo;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return CfgEntidadJudicial
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return CfgEntidadJudicial
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
