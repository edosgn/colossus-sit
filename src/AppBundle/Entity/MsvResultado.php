<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvResultado
 *
 * @ORM\Table(name="msv_resultado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvResultadoRepository")
 */
class MsvResultado
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvCategoria")
     **/
    protected $nombrePilar;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_obtenido", type="integer", length=255)
     */
    private $valorObtenido;

    /**
     * @var int
     *
     * @ORM\Column(name="valor_ponderado", type="integer", length=255)
     */
    private $valorPonderado;

    /**
     * @var int
     *
     * @ORM\Column(name="resultado", type="integer", length=255)
     */
    private $resultado;


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
     * Set valorObtenido
     *
     * @param integer $valorObtenido
     *
     * @return MsvResultado
     */
    public function setValorObtenido($valorObtenido)
    {
        $this->valorObtenido = $valorObtenido;

        return $this;
    }

    /**
     * Get valorObtenido
     *
     * @return integer
     */
    public function getValorObtenido()
    {
        return $this->valorObtenido;
    }

    /**
     * Set valorPonderado
     *
     * @param integer $valorPonderado
     *
     * @return MsvResultado
     */
    public function setValorPonderado($valorPonderado)
    {
        $this->valorPonderado = $valorPonderado;

        return $this;
    }

    /**
     * Get valorPonderado
     *
     * @return integer
     */
    public function getValorPonderado()
    {
        return $this->valorPonderado;
    }

    /**
     * Set resultado
     *
     * @param integer $resultado
     *
     * @return MsvResultado
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return integer
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Set nombrePilar
     *
     * @param \AppBundle\Entity\MsvCategoria $nombrePilar
     *
     * @return MsvResultado
     */
    public function setNombrePilar(\AppBundle\Entity\MsvCategoria $nombrePilar = null)
    {
        $this->nombrePilar = $nombrePilar;

        return $this;
    }

    /**
     * Get nombrePilar
     *
     * @return \AppBundle\Entity\MsvCategoria
     */
    public function getNombrePilar()
    {
        return $this->nombrePilar;
    }
}
