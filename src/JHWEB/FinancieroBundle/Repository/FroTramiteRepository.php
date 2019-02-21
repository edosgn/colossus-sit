<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroTramiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroTramiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findTramiteByFecha($params) {
        $em = $this->getEntityManager();

        $fechaInicio = new \Datetime($params->fechaDesde);
        $fechaFin = new \Datetime($params->fechaHasta);
        $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->idSedeOperativa);

        $dql = "SELECT fr
            FROM JHWEBFinancieroBundle:FroRecaudo fr, JHWEBFinancieroBundle:FroTramite ft, AppBundle:SedeOperativa s, JHWEBFinancieroBundle:FroFactura ff, JHWEBFinancieroBundle:FroTrtePrecio ftp, JHWEBFinancieroBundle:FroTrteConcepto ftc, JHWEBFinancieroBundle:FroCfgTrteConcepto fctc
            WHERE fr.fecha BETWEEN :fechaInicio AND :fechaFin
            AND ff.sedeOperativa = :sedeOperativa
            AND ff.estado = 'PAGADO'
            AND ftp.id = fctc.precio
            AND ftc.concepto = fctc.id
            AND fr.froFactura = ff.id";
        
        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'sedeOperativa' => $sedeOperativa,
        ));

        return $consulta->getResult();
    } 
}
