<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramitePrecio
 *
 * @ORM\Table(name="tramite_precio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramitePrecioRepository")
 */
class TramitePrecio
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
     * @ORM\Column(name="valor", type="string", length=255, nullable = true)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=255)
     */
    private $anio;


    /**
     * @var string
     *
     * @ORM\Column(name="smldv", type="string", length=255)
     */
    private $smldv;

    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;



    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tramite", inversedBy="vehiculos") */
    private $tramite;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Clase", inversedBy="vehiculos") */
    private $clase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Modulo", inversedBy="vehiculos") */
    private $modulo;



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
     * Set valor
     *
     * @param string $valor
     *
     * @return TramitePrecio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return TramitePrecio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set smldv
     *
     * @param string $smldv
     *
     * @return TramitePrecio
     */
    public function setSmldv($smldv)
    {
        $this->smldv = $smldv;

        return $this;
    }

    /**
     * Get smldv
     *
     * @return string
     */
    public function getSmldv()
    {
        return $this->smldv;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TramitePrecio
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tramite
     *
     * @param \AppBundle\Entity\Tramite $tramite
     *
     * @return TramitePrecio
     */
    public function setTramite(\AppBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \AppBundle\Entity\Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     *
     * @return TramitePrecio
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set modulo
     *
     * @param \AppBundle\Entity\Modulo $modulo
     *
     * @return TramitePrecio
     */
    public function setModulo(\AppBundle\Entity\Modulo $modulo = null)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
}
