<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LimitacionDatos
 *
 * @ORM\Table(name="limitacion_datos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LimitacionDatosRepository")
 */
class LimitacionDatos
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
     * @ORM\Column(name="fechaRadicacion", type="date")
     */
    private $fechaRadicacion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="placas")
     **/
    protected $departamento;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Municipio", inversedBy="placas")
     **/
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="placas")
     **/
    protected $tipoIdentificacionDemandado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $ciudadanoDemandado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion", inversedBy="placas")
     **/
    protected $tipoIdentificacionDemandante;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ciudadano", inversedBy="facturas")
     **/
    protected $ciudadanoDemandante;

    /**
     * @var string
     *
     * @ORM\Column(name="ordenJudicial", type="string", length=45)
     */
    private $nOrdenJudicial;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgLimitacion", inversedBy="facturas")
     **/
    protected $limitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaExpedicion", type="date")
     */
    private $fechaExpedicion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgTipoProceso", inversedBy="facturas")
     **/
    protected $tipoProceso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CfgEntidadJudicial", inversedBy="facturas")
     **/
    protected $entidadJudicial;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

    /**
     * @var array
     *
     * @ORM\Column(name="datos", type="array")
     */
    private $datos;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;
}

