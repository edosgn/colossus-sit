<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroTrteCfgConcepto
 *
 * @ORM\Table(name="fro_trte_cfg_concepto")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroTrteCfgConceptoRepository")
 */
class FroTrteCfgConcepto
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
     * @ORM\ManyToOne(targetEntity="FroTrteCfgCuenta", inversedBy="conceptos")
     **/
    protected $cuenta;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * @return FroTrteCfgConcepto
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
     * @return FroTrteCfgConcepto
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return FroTrteCfgConcepto
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
     * Set cuenta
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroTrteCfgCuenta $cuenta
     *
     * @return FroTrteCfgConcepto
     */
    public function setCuenta(\JHWEB\FinancieroBundle\Entity\FroTrteCfgCuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroTrteCfgCuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }
}
