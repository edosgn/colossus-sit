<?php

namespace JHWEB\VehiculoBundle\Repository;

/**
 * VhloLimitacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VhloLimitacionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getByDatosAndVehiculo($vehiculoId, $nOrdenJudicial, $fechaExpedicion, $entidadJudicialId, $limitacionId )
    {   
        $em = $this->getEntityManager();
        $dql = "SELECT vl
            FROM AppBundle:Vehiculo v, AppBundle:VehiculoLimitacion vl, 
            AppBundle:LimitacionDatos ld
            WHERE v.id = vl.vehiculo
            AND ld.id = vl.limitacionDatos
            AND ld.nOrdenJudicial = :nOrdenJudicial
            AND ld.fechaExpedicion = :fechaExpedicion
            AND ld.entidadJudicial = :entidadJudicial
            AND ld.limitacion = :limitacionId
            AND v.id = :vehiculoId";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'vehiculoId' => $vehiculoId,
            'nOrdenJudicial' => $nOrdenJudicial,
            'fechaExpedicion' => $fechaExpedicion,
            'entidadJudicial' => $entidadJudicialId,
            'limitacionId' => $limitacionId,
        ));

        return $consulta->getOneOrNullResult();
    }

        //Obtiene el vehículo según un numero de placa, si tiene una limitacion activa 
    public function getByPlacaAndEstadoLimitacion($placa)
    {   
        $em = $this->getEntityManager();
        $dql = "SELECT vl
            FROM AppBundle:Vehiculo v, AppBundle:CfgPlaca p, AppBundle:VehiculoLimitacion vl
            WHERE v.placa = p.id
            AND p.numero = :placa
            AND vl.estado = true
            AND v.id = vl.vehiculo";
        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'placa' => $placa,
        ));

        return $consulta->getResult();
    }

    //Obtiene el vehículo según un numero de placa y módulo
    public function getByModulo($moduloId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT vl
            FROM AppBundle:VehiculoLimitacion vl, 
            AppBundle:Vehiculo v, 
            AppBundle:Clase c, 
            AppBundle:Modulo m
            WHERE vl.vehiculo = v.id
            AND v.clase = c.id
            AND c.modulo = m.id
            AND m.id = :moduloId";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'moduloId' => $moduloId,
        ));

        return $consulta->getResult();
    }
}
