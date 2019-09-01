<?php

namespace JHWEB\BancoProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BpReduccionRegistroCompromiso
 *
 * @ORM\Table(name="bp_reduccion_registro_compromiso")
 * @ORM\Entity(repositoryClass="JHWEB\BancoProyectoBundle\Repository\BpReduccionRegistroCompromisoRepository")
 */
class BpReduccionRegistroCompromiso
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return BpReduccionRegistroCompromiso
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
     * @return BpReduccionRegistroCompromiso
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
     * @return BpReduccionRegistroCompromiso
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BpReduccionRegistroCompromiso
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
     * Set registroCompromiso
     *
     * @param \JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso $registroCompromiso
     *
     * @return BpReduccionRegistroCompromiso
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
     * @return BpReduccionRegistroCompromiso
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
