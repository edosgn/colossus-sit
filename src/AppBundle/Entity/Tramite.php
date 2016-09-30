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
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="redondeo", type="string", length=255)
     */
    private $redondeo;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var bool
     *
     * @ORM\Column(name="afectacion", type="boolean")
     */
    private $afectacion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="Tramites")
     **/
    protected $modulo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Concepto", mappedBy="tramite")
     */
    protected $conceptos;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Variante", mappedBy="tramite")
     */
    protected $variantes; 

     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pago", mappedBy="tramite")
     */
    protected $pagos;  

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Caso", mappedBy="tramite")
     */
    protected $casos;  

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TramiteEspecifico", mappedBy="tramite")
     */
    protected $tramitesEspecifico;

    public function __construct() {
        $this->conceptos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->variantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->casos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tramitesEspecifico = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return Tramite
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set redondeo
     *
     * @param string $redondeo
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
     * @return string
     */
    public function getRedondeo()
    {
        return $this->redondeo;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     *
     * @return Tramite
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
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
     * Add concepto
     *
     * @param \AppBundle\Entity\Concepto $concepto
     *
     * @return Tramite
     */
    public function addConcepto(\AppBundle\Entity\Concepto $concepto)
    {
        $this->conceptos[] = $concepto;

        return $this;
    }

    /**
     * Remove concepto
     *
     * @param \AppBundle\Entity\Concepto $concepto
     */
    public function removeConcepto(\AppBundle\Entity\Concepto $concepto)
    {
        $this->conceptos->removeElement($concepto);
    }

    /**
     * Get conceptos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptos()
    {
        return $this->conceptos;
    }

    /**
     * Add variante
     *
     * @param \AppBundle\Entity\Variante $variante
     *
     * @return Tramite
     */
    public function addVariante(\AppBundle\Entity\Variante $variante)
    {
        $this->variantes[] = $variante;

        return $this;
    }

    /**
     * Remove variante
     *
     * @param \AppBundle\Entity\Variante $variante
     */
    public function removeVariante(\AppBundle\Entity\Variante $variante)
    {
        $this->variantes->removeElement($variante);
    }

    /**
     * Get variantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariantes()
    {
        return $this->variantes;
    }

    /**
     * Add pago
     *
     * @param \AppBundle\Entity\Pago $pago
     *
     * @return Tramite
     */
    public function addPago(\AppBundle\Entity\Pago $pago)
    {
        $this->pagos[] = $pago;

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \AppBundle\Entity\Pago $pago
     */
    public function removePago(\AppBundle\Entity\Pago $pago)
    {
        $this->pagos->removeElement($pago);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * Add caso
     *
     * @param \AppBundle\Entity\Caso $caso
     *
     * @return Tramite
     */
    public function addCaso(\AppBundle\Entity\Caso $caso)
    {
        $this->casos[] = $caso;

        return $this;
    }

    /**
     * Remove caso
     *
     * @param \AppBundle\Entity\Caso $caso
     */
    public function removeCaso(\AppBundle\Entity\Caso $caso)
    {
        $this->casos->removeElement($caso);
    }

    /**
     * Get casos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasos()
    {
        return $this->casos;
    }

    /**
     * Add tramitesEspecifico
     *
     * @param \AppBundle\Entity\TramiteEspecifico $tramitesEspecifico
     *
     * @return Tramite
     */
    public function addTramitesEspecifico(\AppBundle\Entity\TramiteEspecifico $tramitesEspecifico)
    {
        $this->tramitesEspecifico[] = $tramitesEspecifico;

        return $this;
    }

    /**
     * Remove tramitesEspecifico
     *
     * @param \AppBundle\Entity\TramiteEspecifico $tramitesEspecifico
     */
    public function removeTramitesEspecifico(\AppBundle\Entity\TramiteEspecifico $tramitesEspecifico)
    {
        $this->tramitesEspecifico->removeElement($tramitesEspecifico);
    }

    /**
     * Get tramitesEspecifico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTramitesEspecifico()
    {
        return $this->tramitesEspecifico;
    }
}
