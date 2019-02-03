<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTramite
 *
 * @ORM\Table(name="fro_tramite")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTramiteRepository")
 */
class FroTramite
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
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="sustrato", type="boolean")
     */
    private $sustrato;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgModulo", inversedBy="tramites")
     **/
    protected $modulo;


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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return FroTramite
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FroTramite
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
     * Set sustrato
     *
     * @param boolean $sustrato
     *
     * @return FroTramite
     */
    public function setSustrato($sustrato)
    {
        $this->sustrato = $sustrato;

        return $this;
    }

    /**
     * Get sustrato
     *
     * @return bool
     */
    public function getSustrato()
    {
        return $this->sustrato;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTramite
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set modulo
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgModulo $modulo
     *
     * @return FroTramite
     */
    public function setModulo(\JHWEB\ConfigBundle\Entity\CfgModulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgModulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
