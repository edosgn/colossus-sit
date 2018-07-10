<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComparendoInfraccion
 *
 * @ORM\Table(name="comparendo_infraccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComparendoInfraccionRepository")
 */
class ComparendoInfraccion
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comparendo", inversedBy="comparendosInfracciones")
     **/
    protected $comparendo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MflInfraccion", inversedBy="comparendosInfracciones")
     **/
    protected $infraccion;


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
     * Set comparendo
     *
     * @param \AppBundle\Entity\Comparendo $comparendo
     *
     * @return ComparendoInfraccion
     */
    public function setComparendo(\AppBundle\Entity\Comparendo $comparendo = null)
    {
        $this->comparendo = $comparendo;

        return $this;
    }

    /**
     * Get comparendo
     *
     * @return \AppBundle\Entity\Comparendo
     */
    public function getComparendo()
    {
        return $this->comparendo;
    }

    /**
     * Set infraccion
     *
     * @param \AppBundle\Entity\MflInfraccion $infraccion
     *
     * @return ComparendoInfraccion
     */
    public function setInfraccion(\AppBundle\Entity\MflInfraccion $infraccion = null)
    {
        $this->infraccion = $infraccion;

        return $this;
    }

    /**
     * Get infraccion
     *
     * @return \AppBundle\Entity\MflInfraccion
     */
    public function getInfraccion()
    {
        return $this->infraccion;
    }
}
