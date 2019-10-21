<?php

namespace JHWEB\PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PnalCfgCdoConsecutivo
 *
 * @ORM\Table(name="pnal_cfg_cdo_consecutivo")
 * @ORM\Entity(repositoryClass="JHWEB\PersonalBundle\Repository\PnalCfgCdoConsecutivoRepository")
 */
class PnalCfgCdoConsecutivo
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
     * @ORM\Column(name="numero", type="string", length=100)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_asignacion", type="date", nullable=true)
     */
    private $fechaAsignacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="polca", type="boolean", nullable=true)
     */
    private $polca;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="consecutivos")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="PnalFuncionario", inversedBy="consecutivos")
     **/
    protected $funcionario;

    /**
     * @ORM\ManyToOne(targetEntity="PnalAsignacion", inversedBy="consecutivos")
     **/
    protected $asignacion;


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
     * @param string $numero
     *
     * @return PnalCfgCdoConsecutivo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     *
     * @return PnalCfgCdoConsecutivo
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
     * @return PnalCfgCdoConsecutivo
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
     * Set polca
     *
     * @param boolean $polca
     *
     * @return PnalCfgCdoConsecutivo
     */
    public function setPolca($polca)
    {
        $this->polca = $polca;

        return $this;
    }

    /**
     * Get polca
     *
     * @return boolean
     */
    public function getPolca()
    {
        return $this->polca;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return PnalCfgCdoConsecutivo
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
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return PnalCfgCdoConsecutivo
     */
    public function setOrganismoTransito(\JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito = null)
    {
        $this->organismoTransito = $organismoTransito;

        return $this;
    }

    /**
     * Get organismoTransito
     *
     * @return \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito
     */
    public function getOrganismoTransito()
    {
        return $this->organismoTransito;
    }

    /**
     * Set funcionario
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalFuncionario $funcionario
     *
     * @return PnalCfgCdoConsecutivo
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

    /**
     * Set asignacion
     *
     * @param \JHWEB\PersonalBundle\Entity\PnalAsignacion $asignacion
     *
     * @return PnalCfgCdoConsecutivo
     */
    public function setAsignacion(\JHWEB\PersonalBundle\Entity\PnalAsignacion $asignacion = null)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return \JHWEB\PersonalBundle\Entity\PnalAsignacion
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }
}
