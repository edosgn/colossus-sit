<?php

namespace JHWEB\FinancieroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FroReporteIngresos
 *
 * @ORM\Table(name="fro_reporte_ingresos")
 * @ORM\Entity(repositoryClass="JHWEB\FinancieroBundle\Repository\FroReporteIngresosRepository")
 */
class FroReporteIngresos
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

