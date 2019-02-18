<?php

namespace AppBundle\Repository;

/**
 * TramiteSolicitudRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TramiteSolicitudRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByVehiculoAndDate($datos)
    {     
        $fechaDesde = new \DateTime($datos->fechaDesde);
        $fechaHasta = new \DateTime($datos->fechaHasta);
        $em = $this->getEntityManager();
        $dql = "SELECT ts
            FROM AppBundle:TramiteSolicitud ts, AppBundle:TramiteFactura tf, AppBundle:Factura f
            WHERE ts.tramiteFactura = tf.id
            AND tf.factura = f.id
            AND f.vehiculo = :vehiculoId
            AND ts.fecha BETWEEN :fechaDesde AND :fechaHasta";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'vehiculoId' => $datos->idVehiculo,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ));
        return $consulta->getResult();
    }

    public function findByVehiculoOrderTramite($idVehiculo)
    {     
        $em = $this->getEntityManager();
        $dql = "SELECT t
            FROM AppBundle:TramiteSolicitud ts,AppBundle:TramiteFactura tf, AppBundle:TramitePrecio tp, AppBundle:Tramite t
            WHERE ts.tramiteFactura = tf.id
            AND tf.tramitePrecio = tp.id
            AND tp.tramite = t.id
            AND ts.vehiculo = :vehiculoId
            GROUP BY t.id";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'vehiculoId' => $idVehiculo,
        ));
        return $consulta->getResult();
    }

    public function getTramitesVehiculo($vehiculoId)
    {   
        $em = $this->getEntityManager();
        $dql = "SELECT ts
            FROM AppBundle:TramiteSolicitud ts, AppBundle:TramiteFactura tf, AppBundle:Factura f
            WHERE ((ts.tramiteFactura = tf.id)
            AND (tf.factura = f.id)
            AND (f.vehiculo = :vehiculoId)
            )
            ";
        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'vehiculoId' => $vehiculoId,
        ));
        return $consulta->getResult();
    }
    // consulta para agrupar y hace conte por cada uno de tramite 
   public function getTramiteReportes()
    {   
        $em = $this->getEntityManager();
        $dql = "SELECT ts, count(ts.tramiteFactura) as conteo
                FROM AppBundle:tramiteSolicitud ts
                GROUP BY ts.tramiteFactura
                ORDER BY ts.id ASC";
        $consulta = $em->createQuery($dql);
        
        return $consulta->getResult();
    }
    // consulta para agrupar y hace conte por cada uno de tramite segun las fechas 
    public function getReporteFecha($datos)
    {   

        $desde = new \DateTime($datos->desde);
        $hasta = new \DateTime($datos->hasta);
        $sedeOperativa = ($datos->sedeOperativa);
 
        $em = $this->getEntityManager(); 
        $dql = "SELECT ts, count(ts.tramiteFactura) as conteo
                FROM AppBundle:tramiteSolicitud ts, AppBundle:tramiteFactura tf, 
                     AppBundle:factura f, AppBundle:sedeOperativa so
                WHERE ts.fecha BETWEEN :desde AND :hasta 
                AND ts.tramiteFactura = tf.id AND tf.factura = f.id
                AND f.sedeOperativa = so.id AND so.id = :sedeOperativa
                GROUP BY ts.tramiteFactura
                ORDER BY ts.id ASC";
        $consulta = $em->createQuery($dql);
        // var_dump($consulta);
        // die();
        
        $consulta->setParameters(array(
            'desde' => $desde,
            'hasta' => $hasta,
            'sedeOperativa' => $sedeOperativa,
        ));
        
        return $consulta->getResult();
    }

    public function getByModuloAndFilter($params)
    {
        $em = $this->getEntityManager();

        switch ($params->tipoFiltro) {
            case 1:
                $dql = "SELECT ts
                FROM AppBundle:TramiteSolicitud ts, AppBundle:TramiteFactura tf,
                AppBundle:Factura f, AppBundle:Modulo m, 
                AppBundle:TramitePrecio tp, AppBundle:Vehiculo v,
                AppBundle:CfgPlaca p
                WHERE ts.vehiculo = v.id
                AND v.placa = p.id
                AND p.numero = :placa
                AND tf.factura = f.id 
                AND tf.tramitePrecio = tp.id
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
                FROM AppBundle:TramiteSolicitud ts, AppBundle:TramiteFactura tf,
                AppBundle:Factura f, AppBundle:Modulo m, 
                AppBundle:TramitePrecio tp, AppBundle:Vehiculo v,
                AppBundle:CfgPlaca p
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
                FROM AppBundle:TramiteSolicitud ts, AppBundle:TramiteFactura tf,
                AppBundle:Factura f, AppBundle:Modulo m, 
                AppBundle:TramitePrecio tp, AppBundle:Vehiculo v,
                AppBundle:CfgPlaca p
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

    public function getMatriculaCancelada($idVehiculo)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT ts
            FROM AppBundle:TramiteFactura tf, AppBundle:Tramite t,
            AppBundle:TramitePrecio tp, AppBundle:TramiteSolicitud ts
            WHERE tf.tramitePrecio = tp.id
            AND tp.tramite = t.id
            AND t.codigo = 15
            AND ts.tramiteFactura = tf.id
            AND ts.vehiculo = :idVehiculo
            AND tf.realizado = true";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idVehiculo' => $idVehiculo,
        ));

        return $consulta->getOneOrNullResult();
    }    
}
