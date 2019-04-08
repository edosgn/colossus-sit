<?php

namespace JHWEB\BancoProyectoBundle\Repository;

/**
 * BpCuentaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BpCuentaRepository extends \Doctrine\ORM\EntityRepository
{
	//Obtiene la suma de los costos de cuentas por proyecto
    public function getCostoTotalByProyecto($idProyecto)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT SUM(c.costoTotal) AS total
            FROM JHWEBBancoProyectoBundle:BpCuenta c
            WHERE c.proyecto = :idProyecto
            AND c.activo = true";
            
        $consulta = $em->createQuery($dql);

        $consulta->setParameter('idProyecto', $idProyecto);

        return $consulta->getOneOrNullResult();
    }
}
