<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 

/**
 * Campo_Tramite
 *
 * @ORM\Table(name="campo__tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Campo_TramiteRepository")
 */
class Campo_Tramite
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo_Tramite", inversedBy="camposTramite")
     **/
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Caso_Tramite", inversedBy="camposTramite")
     **/
    protected $casoTramite;


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
     * Set campoTabla
     *
     * @param \AppBundle\Entity\Campo_Tabla $campoTabla
     *
     * @return Campo_Tramite
     */
    public function setCampoTabla(\AppBundle\Entity\Campo_Tabla $campoTabla = null)
    {
        $this->campo_Tabla = $campoTabla;

        return $this;
    }

    /**
     * Get campoTabla
     *
     * @return \AppBundle\Entity\Campo_Tabla
     */
    public function getCampoTabla()
    {
        return $this->campo_Tabla;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipo_Id $tipo
     *
     * @return Campo_Tramite
     */
    public function setTipo(\AppBundle\Entity\Tipo_Id $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipo_Id
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set casoTramite
     *
     * @param \AppBundle\Entity\Caso_Tramite $casoTramite
     *
     * @return Campo_Tramite
     */
    public function setCasoTramite(\AppBundle\Entity\Caso_Tramite $casoTramite = null)
    {
        $this->caso_Tramite = $casoTramite;

        return $this;
    }

    /**
     * Get casoTramite
     *
     * @return \AppBundle\Entity\Caso_Tramite
     */
    public function getCasoTramite()
    {
        return $this->caso_Tramite;
    }
}
