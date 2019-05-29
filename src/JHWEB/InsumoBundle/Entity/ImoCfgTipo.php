<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoCfgTipo
 *
 * @ORM\Table(name="imo_cfg_tipo")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoCfgTipoRepository")
 */
class ImoCfgTipo
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
     * @ORM\Column(name="referencia", type="string", length=255, nullable = true)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255)
     */
    private $categoria;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
   
    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgModulo")
     **/
    protected $modulo;

    /**
    * @ORM\OneToMany(targetEntity="ImoCfgValor", mappedBy="tipo", cascade={"remove"})
    */
    private $valores;

    public function __construct() {
        $this->valores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ImoCfgTipo
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
     * Set referencia
     *
     * @param string $referencia
     *
     * @return ImoCfgTipo
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return ImoCfgTipo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return ImoCfgTipo
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
     * Set modulo
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgModulo $modulo
     *
     * @return ImoCfgTipo
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

    /**
     * Add valore
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoCfgValor $valore
     *
     * @return ImoCfgTipo
     */
    public function addValore(\JHWEB\InsumoBundle\Entity\ImoCfgValor $valore)
    {
        $this->valores[] = $valore;

        return $this;
    }

    /**
     * Remove valore
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoCfgValor $valore
     */
    public function removeValore(\JHWEB\InsumoBundle\Entity\ImoCfgValor $valore)
    {
        $this->valores->removeElement($valore);
    }

    /**
     * Get valores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValores()
    {
        return $this->valores;
    }
}
