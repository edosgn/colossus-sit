<?php

namespace JHWEB\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgClave
 *
 * @ORM\Table(name="cfg_clave")
 * @ORM\Entity(repositoryClass="JHWEB\ConfigBundle\Repository\CfgClaveRepository")
 */
class CfgClave
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
     * @ORM\Column(name="codigo", type="string", length=5)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_creacion", type="time")
     */
    private $horaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date")
     */
    private $fechaVencimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_vencimiento", type="time")
     */
    private $horaVencimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\PersonalBundle\Entity\PnalFuncionario", inversedBy="tramitesSolicitud")
     **/
    protected $funcionario;


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
     * @param string $codigo
     *
     * @return CfgClave
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return CfgClave
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return CfgClave
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set horaCreacion
     *
     * @param \DateTime $horaCreacion
     *
     * @return CfgClave
     */
    public function setHoraCreacion($horaCreacion)
    {
        $this->horaCreacion = $horaCreacion;

        return $this;
    }

    /**
     * Get horaCreacion
     *
     * @return \DateTime
     */
    public function getHoraCreacion()
    {
        return $this->horaCreacion;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     *
     * @return CfgClave
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set horaVencimiento
     *
     * @param \DateTime $horaVencimiento
     *
     * @return CfgClave
     */
    public function setHoraVencimiento($horaVencimiento)
    {
        $this->horaVencimiento = $horaVencimiento;

        return $this;
    }

    /**
     * Get horaVencimiento
     *
     * @return \DateTime
     */
    public function getHoraVencimiento()
    {
        return $this->horaVencimiento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CfgClave
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
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return CfgClave
     */
    public function setFuncionario(\JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
