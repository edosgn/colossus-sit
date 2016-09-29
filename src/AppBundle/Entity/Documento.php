<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 */
class Documento
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
     * @ORM\Column(name="nombreDocuemento", type="string", length=255)
     */
    private $nombreDocuemento;


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
     * Set nombreDocuemento
     *
     * @param string $nombreDocuemento
     *
     * @return Documento
     */
    public function setNombreDocuemento($nombreDocuemento)
    {
        $this->nombreDocuemento = $nombreDocuemento;

        return $this;
    }

    /**
     * Get nombreDocuemento
     *
     * @return string
     */
    public function getNombreDocuemento()
    {
        return $this->nombreDocuemento;
    }
}

