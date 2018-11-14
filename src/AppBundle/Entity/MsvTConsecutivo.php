<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvTConsecutivo
 *
 * @ORM\Table(name="msv_t_consecutivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvTConsecutivoRepository")
 */
class MsvTConsecutivo
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
     * @ORM\Column(name="consecutivo", type="bigint")
     */
    private $consecutivo;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvTalonario", inversedBy="msvTConsecutivos")
     **/
    protected $msvTalonario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAsignacion", type="date", nullable=true)
     */
    private $fechaAsignacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100, )
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SedeOperativa", inversedBy="comparendos")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="comparendos")
     **/
    protected $funcionario;

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
     * Set consecutivo
     *
     * @param integer $consecutivo
     *
     * @return MsvTConsecutivo
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return integer
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return MsvTConsecutivo
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return MsvTConsecutivo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MsvTConsecutivo
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
     * Set msvTalonario
     *
     * @param \AppBundle\Entity\MsvTalonario $msvTalonario
     *
     * @return MsvTConsecutivo
     */
    public function setMsvTalonario(\AppBundle\Entity\MsvTalonario $msvTalonario = null)
    {
        $this->msvTalonario = $msvTalonario;

        return $this;
    }

    /**
     * Get msvTalonario
     *
     * @return \AppBundle\Entity\MsvTalonario
     */
    public function getMsvTalonario()
    {
        return $this->msvTalonario;
    }

    /**
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return MsvTConsecutivo
     */
    public function setSedeOperativa(\AppBundle\Entity\SedeOperativa $sedeOperativa = null)
    {
        $this->sedeOperativa = $sedeOperativa;

        return $this;
    }

    /**
     * Get sedeOperativa
     *
     * @return \AppBundle\Entity\SedeOperativa
     */
    public function getSedeOperativa()
    {
        return $this->sedeOperativa;
    }

    /**
     * Set funcionario
     *
     * @param \AppBundle\Entity\MpersonalFuncionario $funcionario
     *
     * @return MsvTConsecutivo
     */
    public function setFuncionario(\AppBundle\Entity\MpersonalFuncionario $funcionario = null)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get funcionario
     *
     * @return \AppBundle\Entity\MpersonalFuncionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}
