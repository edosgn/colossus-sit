<?php

namespace JHWEB\InsumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImoInsumo
 *
 * @ORM\Table(name="imo_insumo")
 * @ORM\Entity(repositoryClass="JHWEB\InsumoBundle\Repository\ImoInsumoRepository")
 */
class ImoInsumo
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
     * @ORM\Column(name="numero", type="string", length=255, nullable = true)
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
     * @ORM\Column(name="categoria", type="string")
     */
    private $categoria;

    /**
     * @var int
     *
     * @ORM\Column(name="actaEntrega", type="integer")
     */
    private $actaEntrega;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito")
     **/
    protected $organismoTransito;

    /**
     * @ORM\ManyToOne(targetEntity="ImoCfgTipo")
     **/
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="ImoLote")
     **/
    protected $lote;

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
     * @return ImoInsumo
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
     * @return ImoInsumo
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
     * @return ImoInsumo
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
     * Set categoria
     *
     * @param string $categoria
     *
     * @return ImoInsumo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set actaEntrega
     *
     * @param integer $actaEntrega
     *
     * @return ImoInsumo
     */
    public function setActaEntrega($actaEntrega)
    {
        $this->actaEntrega = $actaEntrega;

        return $this;
    }

    /**
     * Get actaEntrega
     *
     * @return integer
     */
    public function getActaEntrega()
    {
        return $this->actaEntrega;
    }

    /**
     * Set organismoTransito
     *
     * @param \JHWEB\ConfigBundle\Entity\CfgOrganismoTransito $organismoTransito
     *
     * @return ImoInsumo
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
     * Set tipo
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoCfgTipo $tipo
     *
     * @return ImoInsumo
     */
    public function setTipo(\JHWEB\InsumoBundle\Entity\ImoCfgTipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoCfgTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set lote
     *
     * @param \JHWEB\InsumoBundle\Entity\ImoLote $lote
     *
     * @return ImoInsumo
     */
    public function setLote(\JHWEB\InsumoBundle\Entity\ImoLote $lote = null)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return \JHWEB\InsumoBundle\Entity\ImoLote
     */
    public function getLote()
    {
        return $this->lote;
    }
}
