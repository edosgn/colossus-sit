<?php

namespace AppBundle\Repository;

/**
 * TramiteFacturaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TramiteFacturaRepository extends \Doctrine\ORM\EntityRepository
{
    // public function getFacturaModulo($moduloId, $idFactura, $vehiculoId)
    // {
    //     $em = $this->getEntityManager();
    //     $dql = "SELECT tf
    //         FROM AppBundle:TramiteFactura tf, AppBundle:Factura f, AppBundle:Modulo m, AppBundle:TramitePrecio tp
    //         WHERE tf.factura = f.id
    //         AND f.id = :idFactura";
    //     $consulta = $em->createQuery($dql);

    //     $consulta->setParameters(array(
    //         'idFactura' => $idFactura,
    //     ));
    //     return $consulta->getResult();

    // }
    public function getFacturaModulo($moduloId, $idFactura, $vehiculoId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT tf
            FROM AppBundle:TramiteFactura tf, AppBundle:Factura f, AppBundle:Modulo m, AppBundle:TramitePrecio tp
            WHERE tf.factura = f.id
            AND f.numero = :idFactura"; 
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idFactura' => $idFactura,
        ));
        return $consulta->getResult();

    }

    public function getByFacturaAndTramite($idFactura, $tramiteId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT tf
            FROM AppBundle:TramiteFactura tf, AppBundle:Factura f, AppBundle:Tramite t, AppBundle:TramitePrecio tp
            WHERE tf.factura = f.id
            AND tf.tramitePrecio = tp.id
            AND tp.tramite = t.id
            AND t.id = :tramiteId
            AND f.id = :idFactura"; 
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idFactura' => $idFactura,
            'tramiteId' => $tramiteId,
        ));
        return $consulta->getOneOrNullResult();

    }
}
