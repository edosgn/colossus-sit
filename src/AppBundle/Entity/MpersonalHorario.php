<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpersonalHorario
 *
 * @ORM\Table(name="mpersonal_horario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MpersonalHorarioRepository")
 */
class MpersonalHorario
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
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaInicio", type="time")
     */
    private $horaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaFin", type="time")
     */
    private $horaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="jornada", type="string", length=100)
     */
    private $jornada;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=100)
     */
    private $lugar;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MpersonalFuncionario", inversedBy="horarios")
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MpersonalHorario
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
        if ($this->fecha) {
            return $this->fecha->format('Y-m-d');
        }
        return $this->fecha;
    }

    /**
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     *
     * @return MpersonalHorario
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio->format('H:m:s');
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     *
     * @return MpersonalHorario
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin->format('H:m:s');
    }

    /**
     * Set jornada
     *
     * @param string $jornada
     *
     * @return MpersonalHorario
     */
    public function setJornada($jornada)
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * Get jornada
     *
     * @return string
     */
    public function getJornada()
    {
        return $this->jornada;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     *
     * @return MpersonalHorario
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MpersonalHorario
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
     * @param \AppBundle\Entity\MpersonalFuncionario $funcionario
     *
     * @return MpersonalHorario
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
