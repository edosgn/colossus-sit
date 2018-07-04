<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsvTConsecutivo
 *
 * @ORM\Table(name="msv_t_consecutivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MsvTConsecutivoRepository")
 */
class MsvTConsecutivo
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
     * @ORM\Column(name="consecutivo", type="string", length=255)
     */
    private $consecutivo;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MsvTalonario", inversedBy="msvTConsecutivos")
     **/
    protected $msvTalonario;


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
     * Set consecutivo
     *
     * @param string $consecutivo
     *
     * @return MsvTConsecutivo
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;

        return $this;
    }

    /**
     * Get consecutivo
     *
     * @return string
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * Set msvTalonario
     *
     * @param \AppBundle\Entity\MsvTalonario $msvTalonario
     *
     * @return MsvTConsecutivo
     */
    public function setMsvTalonario(\AppBundle\Entity\MsvTalonario $msvTalonario = null)
    {
        $this->msvTalonario = $msvTalonario;

        return $this;
    }

    /**
     * Get msvTalonario
     *
     * @return \AppBundle\Entity\MsvTalonario
     */
    public function getMsvTalonario()
    {
        return $this->msvTalonario;
    }
}
