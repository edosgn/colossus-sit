<?php

namespace JHWEB\SeguridadVialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvIpatConsecutivo
 *
 * @ORM\Table(name="sv_ipat_consecutivo")
 * @ORM\Entity(repositoryClass="JHWEB\SeguridadVialBundle\Repository\SvIpatConsecutivoRepository")
 */
class SvIpatConsecutivo
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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="SvIpatTalonario", inversedBy="consecutivos")
     **/
    protected $talonario;

    /**
     * @ORM\ManyToOne(targetEntity="SvIpatAsignacion", inversedBy="consecutivos")
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
     * @param integer $numero
     *
     * @return SvIpatConsecutivo
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
     * Set estado
     *
     * @param string $estado
     *
     * @return SvIpatConsecutivo
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
     * @return SvIpatConsecutivo
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
     * Set talonario
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario $talonario
     *
     * @return SvIpatConsecutivo
     */
    public function setTalonario(\JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario $talonario = null)
    {
        $this->talonario = $talonario;

        return $this;
    }

    /**
     * Get talonario
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatTalonario
     */
    public function getTalonario()
    {
        return $this->talonario;
    }

    /**
     * Set asignacion
     *
     * @param \JHWEB\SeguridadVialBundle\Entity\SvIpatAsignacion $asignacion
     *
     * @return SvIpatConsecutivo
     */
    public function setAsignacion(\JHWEB\SeguridadVialBundle\Entity\SvIpatAsignacion $asignacion = null)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return \JHWEB\SeguridadVialBundle\Entity\SvIpatAsignacion
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }
}
