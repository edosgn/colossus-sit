<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptos_Tramite
 *
 * @ORM\Table(name="conceptos__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Conceptos_TramiteRepository")
 */
class Conceptos_Tramite
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo_Tramite", inversedBy="conceptosTramite")
     **/
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cuenta", inversedBy="conceptosTramite")
     **/
    protected $cuenta;


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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Conceptos_Tramite
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return Conceptos_Tramite
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipos_Tramite $tipo
     *
     * @return Conceptos_Tramite
     */
    public function setTipo(\AppBundle\Entity\Tipos_Tramite $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipos_Tramite
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Conceptos_Tramite
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \AppBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }
}
