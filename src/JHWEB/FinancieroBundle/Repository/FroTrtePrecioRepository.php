<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroTrtePrecioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroTrtePrecioRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRecordByFechas($params) {
        $em = $this->getEntityManager();

        $fechaInicial = new \Datetime($params->fechaInicial);
        $fechaFinal = new \Datetime($params->fechaFinal);

        $dql = "SELECT fp
            FROM JHWEBFinancieroBundle:FroTramite ft, 
            JHWEBFinancieroBundle:FroTrtePrecio fp,
            JHWEBConfigBundle:CfgModulo m
            WHERE fp.tramite = ft.id
            AND fp.modulo = m.id
            AND m.id = :idModulo
            AND (fp.fechaInicial <= :fechaFinal AND fp.fechaFinal >=  :fechaInicial)
            OR (fp.fechaInicial BETWEEN :fechaInicial AND :fechaFinal)";
        
        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'idModulo' => $params->idModulo,
        ));

        return $consulta->getResult();
    }
}
