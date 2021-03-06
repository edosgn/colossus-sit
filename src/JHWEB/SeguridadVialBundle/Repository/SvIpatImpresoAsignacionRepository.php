<?php

namespace JHWEB\SeguridadVialBundle\Repository;

/**
 * SvIpatImpresoAsignacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SvIpatImpresoAsignacionRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de asignaciones por año
    public function getMaximo($anio)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT MAX(a.consecutivo) AS maximo
            FROM JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion a
            WHERE YEAR(a.fecha) = :ANIO";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);

        return $consulta->getOneOrNullResult();
    }

    public function getLastByFechaAndOrganismoTransito($idOrganismoTransito){ 
        $em = $this->getEntityManager();
        
        $dql = "SELECT a
        FROM JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion a
        WHERE a.fecha = (
            SELECT MAX(a2.fecha)
            FROM JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion a2
            WHERE a2.activo = true
            AND a2.organismoTransito = :idOrganismoTransito
        ) 
        AND a.activo = true
        AND a.organismoTransito = :idOrganismoTransito";

        $consulta = $em->createQuery($dql)->setMaxResults(1);
		$consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
        ));

        return $consulta->getOneOrNullResult();
    }

    //Obtiene la suma de cantidad disponible por organismo de transito
    public function getCantidadDisponibleByOrganismoTransito($idOrganismoTransito)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT SUM(a.cantidadDisponible) AS total
            FROM JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion a
            WHERE a.organismoTransito = :idOrganismoTransito
            AND a.activo = true
            GROUP BY a.organismoTransito";
            
        $consulta = $em->createQuery($dql);

        $consulta->setParameter('idOrganismoTransito', $idOrganismoTransito);
        
        return $consulta->getOneOrNullResult();
    }
}
