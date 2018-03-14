<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramiteSistema
 *
 * @ORM\Table(name="tramite_sistema")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteSistemaRepository")
 */
class TramiteSistema
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
     * @ORM\Column(name="codigoTramiteSistema", type="string", length=45)
     */
    private $codigoTramiteSistema;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionTramiteSistema", type="string", length=45)
     */
    private $descripcionTramiteSistema;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaComponente", type="string", length=45)
     */
    private $rutaComponente;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ModuloSistema", inversedBy="tramitesSistemas")
     **/
    protected $moduloSistema;


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
     * Set codigoTramiteSistema
     *
     * @param string $codigoTramiteSistema
     *
     * @return TramiteSistema
     */
    public function setCodigoTramiteSistema($codigoTramiteSistema)
    {
        $this->codigoTramiteSistema = $codigoTramiteSistema;

        return $this;
    }

    /**
     * Get codigoTramiteSistema
     *
     * @return string
     */
    public function getCodigoTramiteSistema()
    {
        return $this->codigoTramiteSistema;
    }

    /**
     * Set descripcionTramiteSistema
     *
     * @param string $descripcionTramiteSistema
     *
     * @return TramiteSistema
     */
    public function setDescripcionTramiteSistema($descripcionTramiteSistema)
    {
        $this->descripcionTramiteSistema = $descripcionTramiteSistema;

        return $this;
    }

    /**
     * Get descripcionTramiteSistema
     *
     * @return string
     */
    public function getDescripcionTramiteSistema()
    {
        return $this->descripcionTramiteSistema;
    }

    /**
     * Set rutaComponente
     *
     * @param string $rutaComponente
     *
     * @return TramiteSistema
     */
    public function setRutaComponente($rutaComponente)
    {
        $this->rutaComponente = $rutaComponente;

        return $this;
    }

    /**
     * Get rutaComponente
     *
     * @return string
     */
    public function getRutaComponente()
    {
        return $this->rutaComponente;
    }

    /**
     * Set moduloSistema
     *
     * @param \AppBundle\Entity\ModuloSistema $moduloSistema
     *
     * @return TramiteSistema
     */
    public function setModuloSistema(\AppBundle\Entity\ModuloSistema $moduloSistema = null)
    {
        $this->moduloSistema = $moduloSistema;

        return $this;
    }

    /**
     * Get moduloSistema
     *
     * @return \AppBundle\Entity\ModuloSistema
     */
    public function getModuloSistema()
    {
        return $this->moduloSistema;
    }
}
