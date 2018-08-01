<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramite
 *
 * @ORM\Table(name="tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteRepository")
 */
class Tramite
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
     * @var bool
     *
     * @ORM\Column(name="redondeo", type="boolean", nullable=true)
     */
    private $redondeo = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="afectacion", type="boolean")
     */
    private $afectacion = false;

     /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado = true;

     /**
     * @var boolean
     *
     * @ORM\Column(name="sustrato", type="boolean", nullable=true)
     */
    private $sustrato = false;

    /**
     * @var string
     *
     * @ORM\Column(name="formulario", type="string", length=255, nullable=true)
     */
    private $formulario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="Tramites")
     **/
    protected $modulo;


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
     * @return Tramite
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
     * Set redondeo
     *
     * @param boolean $redondeo
     *
     * @return Tramite
     */
    public function setRedondeo($redondeo)
    {
        $this->redondeo = $redondeo;

        return $this;
    }

    /**
     * Get redondeo
     *
     * @return boolean
     */
    public function getRedondeo()
    {
        return $this->redondeo;
    }

    /**
     * Set afectacion
     *
     * @param boolean $afectacion
     *
     * @return Tramite
     */
    public function setAfectacion($afectacion)
    {
        $this->afectacion = $afectacion;

        return $this;
    }

    /**
     * Get afectacion
     *
     * @return boolean
     */
    public function getAfectacion()
    {
        return $this->afectacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Tramite
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
     * Set sustrato
     *
     * @param boolean $sustrato
     *
     * @return Tramite
     */
    public function setSustrato($sustrato)
    {
        $this->sustrato = $sustrato;

        return $this;
    }

    /**
     * Get sustrato
     *
     * @return boolean
     */
    public function getSustrato()
    {
        return $this->sustrato;
    }

    /**
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return Tramite
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set formulario
     *
     * @param string $formulario
     *
     * @return Tramite
     */
    public function setFormulario($formulario)
    {
        $this->formulario = $formulario;

        return $this;
    }

    /**
     * Get formulario
     *
     * @return string
     */
    public function getFormulario()
    {
        return $this->formulario;
    }
}
