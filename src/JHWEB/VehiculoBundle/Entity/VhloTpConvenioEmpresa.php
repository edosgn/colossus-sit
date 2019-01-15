<?php

namespace JHWEB\VehiculoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VhloTpConvenioEmpresa
 *
 * @ORM\Table(name="vhlo_tp_convenio_empresa")
 * @ORM\Entity(repositoryClass="JHWEB\VehiculoBundle\Repository\VhloTpConvenioEmpresaRepository")
 */
class VhloTpConvenioEmpresa
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Empresa")
     */
    private $empresa;

    /**
     * @ORM\OneToOne(targetEntity="VhloTpConvenio")
     */
    private $vhloTpConvenio;



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
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return VhloTpConvenioEmpresa
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set vhloTpConvenio
     *
     * @param \JHWEB\VehiculoBundle\Entity\VhloTpConvenio $vhloTpConvenio
     *
     * @return VhloTpConvenioEmpresa
     */
    public function setVhloTpConvenio(\JHWEB\VehiculoBundle\Entity\VhloTpConvenio $vhloTpConvenio = null)
    {
        $this->vhloTpConvenio = $vhloTpConvenio;

        return $this;
    }

    /**
     * Get vhloTpConvenio
     *
     * @return \JHWEB\VehiculoBundle\Entity\VhloTpConvenio
     */
    public function getVhloTpConvenio()
    {
        return $this->vhloTpConvenio;
    }
}
