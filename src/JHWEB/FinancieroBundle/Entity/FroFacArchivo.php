<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroFacArchivo
 *
 * @ORM\Table(name="fro_fac_archivo")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroFacArchivoRepository")
 */
class FroFacArchivo
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
     * @ORM\Column(name="numero_folios", type="integer", nullable=true)
     */
    private $numeroFolios;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_archivador", type="integer", nullable=true)
     */
    private $numeroArchivador;

    /**
     * @var int
     *
     * @ORM\Column(name="bandeja", type="integer", nullable=true)
     */
    private $bandeja;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_caja", type="integer", nullable=true)
     */
    private $numeroCaja;

    /**
     * @var int
     *
     * @ORM\Column(name="rango", type="integer", nullable=true)
     */
    private $rango;

    /**
     * @ORM\ManyToOne(targetEntity="FroFactura", inversedBy="archivos")
     **/
    protected $factura;

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
     * Set numeroFolios
     *
     * @param integer $numeroFolios
     *
     * @return FroFacArchivo
     */
    public function setNumeroFolios($numeroFolios)
    {
        $this->numeroFolios = $numeroFolios;

        return $this;
    }

    /**
     * Get numeroFolios
     *
     * @return integer
     */
    public function getNumeroFolios()
    {
        return $this->numeroFolios;
    }

    /**
     * Set numeroArchivador
     *
     * @param integer $numeroArchivador
     *
     * @return FroFacArchivo
     */
    public function setNumeroArchivador($numeroArchivador)
    {
        $this->numeroArchivador = $numeroArchivador;

        return $this;
    }

    /**
     * Get numeroArchivador
     *
     * @return integer
     */
    public function getNumeroArchivador()
    {
        return $this->numeroArchivador;
    }

    /**
     * Set bandeja
     *
     * @param integer $bandeja
     *
     * @return FroFacArchivo
     */
    public function setBandeja($bandeja)
    {
        $this->bandeja = $bandeja;

        return $this;
    }

    /**
     * Get bandeja
     *
     * @return integer
     */
    public function getBandeja()
    {
        return $this->bandeja;
    }

    /**
     * Set numeroCaja
     *
     * @param integer $numeroCaja
     *
     * @return FroFacArchivo
     */
    public function setNumeroCaja($numeroCaja)
    {
        $this->numeroCaja = $numeroCaja;

        return $this;
    }

    /**
     * Get numeroCaja
     *
     * @return integer
     */
    public function getNumeroCaja()
    {
        return $this->numeroCaja;
    }

    /**
     * Set rango
     *
     * @param integer $rango
     *
     * @return FroFacArchivo
     */
    public function setRango($rango)
    {
        $this->rango = $rango;

        return $this;
    }

    /**
     * Get rango
     *
     * @return integer
     */
    public function getRango()
    {
        return $this->rango;
    }

    /**
     * Set factura
     *
     * @param \JHWEB\FinancieroBundle\Entity\FroFactura $factura
     *
     * @return FroFacArchivo
     */
    public function setFactura(\JHWEB\FinancieroBundle\Entity\FroFactura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \JHWEB\FinancieroBundle\Entity\FroFactura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
