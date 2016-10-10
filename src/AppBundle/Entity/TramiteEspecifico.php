<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteEspecifico
 *
 * @ORM\Table(name="tramite_especifico")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteEspecificoRepository")
 */
class TramiteEspecifico
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
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var array
     *
     * @ORM\Column(name="datos", type="array")
     */
    private $datos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="tramitesEspecifico")
     **/
    protected $tramite;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TramiteGeneral", inversedBy="tramitesEspecifico")
     **/
    protected $tramiteGeneral;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Variante", inversedBy="tramitesEspecifico")
     **/
    protected $variante;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Caso", inversedBy="tramitesEspecifico")
     **/
    protected $caso;


  

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
     * Set valor
     *
     * @param integer $valor
     *
     * @return TramiteEspecifico
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
     * Set datos
     *
     * @param array $datos
     *
     * @return TramiteEspecifico
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramiteEspecifico
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
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return TramiteEspecifico
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set tramiteGeneral
     *
     * @param \AppBundle\Entity\TramiteGeneral $tramiteGeneral
     *
     * @return TramiteEspecifico
     */
    public function setTramiteGeneral(\AppBundle\Entity\TramiteGeneral $tramiteGeneral = null)
    {
        $this->tramiteGeneral = $tramiteGeneral;

        return $this;
    }

    /**
     * Get tramiteGeneral
     *
     * @return \AppBundle\Entity\TramiteGeneral
     */
    public function getTramiteGeneral()
    {
        return $this->tramiteGeneral;
    }

    /**
     * Set variante
     *
     * @param \AppBundle\Entity\Variante $variante
     *
     * @return TramiteEspecifico
     */
    public function setVariante(\AppBundle\Entity\Variante $variante = null)
    {
        $this->variante = $variante;

        return $this;
    }

    /**
     * Get variante
     *
     * @return \AppBundle\Entity\Variante
     */
    public function getVariante()
    {
        return $this->variante;
    }

    /**
     * Set caso
     *
     * @param \AppBundle\Entity\Caso $caso
     *
     * @return TramiteEspecifico
     */
    public function setCaso(\AppBundle\Entity\Caso $caso = null)
    {
        $this->caso = $caso;

        return $this;
    }

    /**
     * Get caso
     *
     * @return \AppBundle\Entity\Caso
     */
    public function getCaso()
    {
        return $this->caso;
    }
}
