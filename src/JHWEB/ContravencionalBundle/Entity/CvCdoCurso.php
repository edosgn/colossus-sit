<?php

namespace JHWEB\ContravencionalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CvCdoCurso
 *
 * @ORM\Table(name="cv_cdo_curso")
 * @ORM\Entity(repositoryClass="JHWEB\ContravencionalBundle\Repository\CvCdoCursoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CvCdoCurso
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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion", type="string", length=20)
     */
    private $identificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="comparendo", type="bigint")
     */
    private $comparendo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** 
    * created Time/Date 
    * 
    * @var \DateTime 
    * 
    * @ORM\Column(name="created_at", type="datetime") 
    */  
    protected $createdAt;  
  
    /** 
     * updated Time/Date 
     * 
     * @var \DateTime 
     * 
     * @ORM\Column(name="updated_at", type="datetime") 
     */  
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="JHWEB\UsuarioBundle\Entity\UserEmpresa")
     */
    private $empresa;

    /** @ORM\PrePersist */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /** @ORM\PreUpdate */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CvCdoCurso
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
        return $this->fecha;
    }

    /**
     * Set identificacion
     *
     * @param string $identificacion
     *
     * @return CvCdoCurso
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return string
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set comparendo
     *
     * @param integer $comparendo
     *
     * @return CvCdoCurso
     */
    public function setComparendo($comparendo)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return int
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CvCdoCurso
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

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set empresa
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa
     *
     * @return CvCdoCurso
     */
    public function setEmpresa(\JHWEB\UsuarioBundle\Entity\UserEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserEmpresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
