<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgComparendoEstado
 *
 * @ORM\Table(name="cfg_comparendo_estado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgComparendoEstadoRepository")
 */
class CfgComparendoEstado
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
     * @ORM\Column(name="sigla", type="string", length=3)
     */
    private $sigla;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var bool
     *
     * @ORM\Column(name="actualiza", type="boolean")
     */
    private $actualiza;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgAdmFormato", inversedBy="estados")
     **/
    protected $formato;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CfgComparendoEstado
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
     * Set sigla
     *
     * @param string $sigla
     *
     * @return CfgComparendoEstado
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgComparendoEstado
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set formato
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgAdmFormato $formato
     *
     * @return CfgComparendoEstado
     */
    public function setFormato(\JHWEB\ConfigBundle\Entity\CfgAdmFormato $formato = null)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgAdmFormato
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set actualiza
     *
     * @param boolean $actualiza
     *
     * @return CfgComparendoEstado
     */
    public function setActualiza($actualiza)
    {
        $this->actualiza = $actualiza;

        return $this;
    }

    /**
     * Get actualiza
     *
     * @return boolean
     */
    public function getActualiza()
    {
        return $this->actualiza;
    }
}
