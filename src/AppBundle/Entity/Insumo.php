<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Insumo
 *
 * @ORM\Table(name="insumo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InsumoRepository")
 */
class Insumo
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
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;


    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string")
     */
    private $tipo;


    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito")
     **/
    protected $sedeOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CasoInsumo")
     **/
    protected $casoInsumo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LoteInsumo")
     **/
    protected $loteInsumo;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return Insumo
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Insumo
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Insumo
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
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Insumo
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
     * Set sedeOperativa
     *
     * @param \AppBundle\Entity\SedeOperativa $sedeOperativa
     *
     * @return Insumo
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
     * Set casoInsumo
     *
     * @param \AppBundle\Entity\CasoInsumo $casoInsumo
     *
     * @return Insumo
     */
    public function setCasoInsumo(\AppBundle\Entity\CasoInsumo $casoInsumo = null)
    {
        $this->casoInsumo = $casoInsumo;

        return $this;
    }

    /**
     * Get casoInsumo
     *
     * @return \AppBundle\Entity\CasoInsumo
     */
    public function getCasoInsumo()
    {
        return $this->casoInsumo;
    }

    /**
     * Set loteInsumo
     *
     * @param \AppBundle\Entity\LoteInsumo $loteInsumo
     *
     * @return Insumo
     */
    public function setLoteInsumo(\AppBundle\Entity\LoteInsumo $loteInsumo = null)
    {
        $this->loteInsumo = $loteInsumo;

        return $this;
    }

    /**
     * Get loteInsumo
     *
     * @return \AppBundle\Entity\LoteInsumo
     */
    public function getLoteInsumo()
    {
        return $this->loteInsumo;
    }
}
