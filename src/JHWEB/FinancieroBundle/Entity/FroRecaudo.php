<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroRecaudo
 *
 * @ORM\Table(name="fro_recaudo")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroRecaudoRepository")
 */
class FroRecaudo
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="date")
     */
    private $fechaPago;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_pago", type="time")
     */
    private $horaPago;

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
     * @ORM\ManyToOne(targetEntity="FroFactura")
     */
    private $froFactura; 

    /** @ORM\ManyToOne(targetEntity="JHWEB\ConfigBundle\Entity\CfgOrganismoTransito", inversedBy="recaudos") */
    private $organismoTransito;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
