<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroTrteSolicitudRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroTrteSolicitudRepository extends \Doctrine\ORM\EntityRepository
{
	public function getByModuloAndFilter($params)
    {
        $em = $this->getEntityManager();

        switch ($params->tipoFiltro) {
            case 1:
                $dql = "SELECT ts
                FROM JHWEBFinancieroBundle:FroTrteSolicitud ts,
                JHWEBFinancieroBundle:FroFacTramite ft,
                JHWEBFinancieroBundle:FroFactura f, 
                JHWEBConfigBundle:CfgModulo m, 
                JHWEBFinancieroBundle:FroTrtePrecio tp,
                JHWEBVehiculoBundle:VhloVehiculo v,
                JHWEBVehiculoBundle:VhloCfgPlaca p
                WHERE ts.vehiculo = v.id
                AND v.placa = p.id
                AND p.numero = :placa
                AND ft.factura = f.id 
                AND ft.tramitePrecio = tp.id
                AND tp.modulo = :idModulo
                ORDER BY ts.fecha DESC";

                $consulta = $em->createQuery($dql);

                $consulta->setParameters(array(
                    'idModulo' => $params->idModulo,
                    'placa' => $params->filtro,
                ));
                break;

            case 2:
                $dql = "SELECT ts
                FROM JHWEBFinancieroBundle:FroTrteSolicitud ts,
                JHWEBFinancieroBundle:FroFacTramite ft,
                JHWEBFinancieroBundle:FroFactura f, 
                JHWEBConfigBundle:CfgModulo m, 
                JHWEBFinancieroBundle:FroTrtePrecio tp,
                JHWEBVehiculoBundle:VhloVehiculo v,
                JHWEBVehiculoBundle:VhloCfgPlaca p
                WHERE ts.vehiculo = v.id
                AND v.placa = p.id
                AND tf.factura = f.id 
                AND tf.tramitePrecio = tp.id
                AND tp.modulo = :idModulo
                AND f.numero = :numero
                ORDER BY ts.fecha DESC";

                $consulta = $em->createQuery($dql);

                $consulta->setParameters(array(
                    'idModulo' => $params->idModulo,
                    'numero' => $params->filtro,
                ));
                break;

            case 3:
                $dql = "SELECT ts
                FROM JHWEBFinancieroBundle:FroTrteSolicitud ts,
                JHWEBFinancieroBundle:FroFacTramite ft,
                JHWEBFinancieroBundle:FroFactura f, 
                JHWEBConfigBundle:CfgModulo m, 
                JHWEBFinancieroBundle:FroTrtePrecio tp,
                JHWEBVehiculoBundle:VhloVehiculo v,
                JHWEBVehiculoBundle:VhloCfgPlaca p
                WHERE ts.vehiculo = v.id
                AND v.placa = p.id
                AND tf.factura = f.id 
                AND tf.tramitePrecio = tp.id
                AND tp.modulo = :idModulo
                AND ts.fecha = :fecha
                ORDER BY ts.fecha DESC";

                $consulta = $em->createQuery($dql);

                $consulta->setParameters(array(
                    'idModulo' => $params->idModulo,
                    'fecha' => $params->filtro,
                ));
                break;
        }

        return $consulta->getResult();
    }
}