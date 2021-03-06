<?php

namespace AppBundle\Repository;

/**
 * FacturaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacturaRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de documentos por año
    public function getMaximo()
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MAX(f.id) AS maximo
            FROM AppBundle:Factura f
            ORDER by f.id DESC";
        // $dql = "SELECT MAX(f.consecutivo) AS maximo
        //     FROM AppBundle:Factura f
        //     WHERE YEAR(f.fechaCreacion) = :ANIO";
        $consulta = $em->createQuery($dql);
        return $consulta->getOneOrNullResult();
    }

    public function getFacturaModulo($moduloId, $id, $vehiculoId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT tf
            FROM AppBundle:TramiteFactura tf, AppBundle:Factura f, AppBundle:Modulo m, AppBundle:TramitePrecio tp
            WHERE ((tf.factura = f.id)
            AND (f.id = :id)
            AND (tf.tramitePrecio = tp.id)
            AND (f.vehiculo = :vehiculoId)
            AND (tp.modulo = :moduloId)

            )
            ";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'moduloId' => $moduloId,
            'id' => $id,
            'vehiculoId' => $vehiculoId,
        ));
        return $consulta->getResult();

    }
}
