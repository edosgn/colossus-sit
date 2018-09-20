<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCfgPorcentajeInicial
 *
 * @ORM\Table(name="cv_cfg_porcentaje_inicial")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCfgPorcentajeInicialRepository")
 */
class CvCfgPorcentajeInicial
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
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     */
    private $valor;

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
     * Set anio
     *
     * @param integer $anio
     *
     * @return CvCfgPorcentajeInicial
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return int
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return CvCfgPorcentajeInicial
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
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
     * @return CvCfgPorcentajeInicial
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }
}

