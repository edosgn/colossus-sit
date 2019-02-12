<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroAcuerdoPagoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroAcuerdoPagoRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de las solicitudes
    public function findMaximo($anio)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MAX(ap.consecutivo) AS maximo
            FROM JHWEBFinancieroBundle:FroAcuerdoPago ap
            WHERE YEAR(ap.fecha) = :ANIO";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);
        return $consulta->getOneOrNullResult();
    }
    
    //Obtiene el acuerdo de pago según el comparendo
    public function getAcuerdoPagoByComparendo($idComparendo)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT ap
            FROM JHWEBFinancieroBundle:FroAcuerdoPago ap,
            JHWEBFinancieroBundle:FroAmortizacion am,
            JHWEBFroFacturaBundle:FroFactura f
            WHERE am.factura = f.id";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);
        return $consulta->getOneOrNullResult();
    }
}
