<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpReduccion
 *
 * @ORM\Table(name="bp_reduccion")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpReduccionRepository")
 */
class BpReduccion
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
     * @ORM\Column(name="numero", type="bigint")
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="justificacion", type="text")
     */
    private $justificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="BpCdp")
     **/
    protected $cdp;

    /**
     * @ORM\ManyToOne(targetEntity="BpRegistroCompromiso")
     **/
    protected $registroCompromiso;

    /** @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="reducciones") */
    private $solicita;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return BpReduccion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BpReduccion
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
     * Set valor
     *
     * @param integer $valor
     *
     * @return BpReduccion
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
     * Set justificacion
     *
     * @param string $justificacion
     *
     * @return BpReduccion
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;

        return $this;
    }

    /**
     * Get justificacion
     *
     * @return string
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return BpReduccion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpReduccion
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
     * Set cdp
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp
     *
     * @return BpReduccion
     */
    public function setCdp(\JHWEB\BancoProyectoBundle\Entity\BpCdp $cdp = null)
    {
        $this->cdp = $cdp;

        return $this;
    }

    /**
     * Get cdp
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpCdp
     */
    public function getCdp()
    {
        return $this->cdp;
    }

    /**
     * Set registroCompromiso
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso $registroCompromiso
     *
     * @return BpReduccion
     */
    public function setRegistroCompromiso(\JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso $registroCompromiso = null)
    {
        $this->registroCompromiso = $registroCompromiso;

        return $this;
    }

    /**
     * Get registroCompromiso
     *
     * @return \JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso
     */
    public function getRegistroCompromiso()
    {
        return $this->registroCompromiso;
    }

    /**
     * Set solicita
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $solicita
     *
     * @return BpReduccion
     */
    public function setSolicita(\JHWEB\PersonalBundle\Entity\PnalFuncionario $solicita = null)
    {
        $this->solicita = $solicita;

        return $this;
    }

    /**
     * Get solicita
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getSolicita()
    {
        return $this->solicita;
    }
}
