<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LiquidacionComparendo
 *
 * @ORM\Table(name="liquidacion_comparendo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LiquidacionComparendoRepository")
 */
class LiquidacionComparendo
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
     * @var float
     *
     * @ORM\Column(name="valorComparendo", type="float")
     */
    private $valorComparendo;

    /**
     * @var float
     *
     * @ORM\Column(name="valorAdicional", type="float")
     */
    private $valorAdicional;

    /**
     * @var float
     *
     * @ORM\Column(name="valorSectranGobernacion", type="float")
     */
    private $valorSectranGobernacion;

    /**
     * @var float
     *
     * @ORM\Column(name="valorPolca", type="float")
     */
    private $valorPolca;

    /**
     * @var float
     *
     * @ORM\Column(name="valorSIMIT", type="float")
     */
    private $valorSIMIT;


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
     * Set valorComparendo
     *
     * @param float $valorComparendo
     *
     * @return LiquidacionComparendo
     */
    public function setValorComparendo($valorComparendo)
    {
        $this->valorComparendo = $valorComparendo;

        return $this;
    }

    /**
     * Get valorComparendo
     *
     * @return float
     */
    public function getValorComparendo()
    {
        return $this->valorComparendo;
    }

    /**
     * Set valorAdicional
     *
     * @param float $valorAdicional
     *
     * @return LiquidacionComparendo
     */
    public function setValorAdicional($valorAdicional)
    {
        $this->valorAdicional = $valorAdicional;

        return $this;
    }

    /**
     * Get valorAdicional
     *
     * @return float
     */
    public function getValorAdicional()
    {
        return $this->valorAdicional;
    }

    /**
     * Set valorSectranGobernacion
     *
     * @param float $valorSectranGobernacion
     *
     * @return LiquidacionComparendo
     */
    public function setValorSectranGobernacion($valorSectranGobernacion)
    {
        $this->valorSectranGobernacion = $valorSectranGobernacion;

        return $this;
    }

    /**
     * Get valorSectranGobernacion
     *
     * @return float
     */
    public function getValorSectranGobernacion()
    {
        return $this->valorSectranGobernacion;
    }

    /**
     * Set valorPolca
     *
     * @param float $valorPolca
     *
     * @return LiquidacionComparendo
     */
    public function setValorPolca($valorPolca)
    {
        $this->valorPolca = $valorPolca;

        return $this;
    }

    /**
     * Get valorPolca
     *
     * @return float
     */
    public function getValorPolca()
    {
        return $this->valorPolca;
    }

    /**
     * Set valorSIMIT
     *
     * @param float $valorSIMIT
     *
     * @return LiquidacionComparendo
     */
    public function setValorSIMIT($valorSIMIT)
    {
        $this->valorSIMIT = $valorSIMIT;

        return $this;
    }

    /**
     * Get valorSIMIT
     *
     * @return float
     */
    public function getValorSIMIT()
    {
        return $this->valorSIMIT;
    }
}
